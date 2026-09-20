<?php
/**
 * Creates local/demo users without storing credentials in source control.
 *
 * Set RAPID_RESCUE_SEED_PASSWORD in the runtime environment when demo users
 * are required. Never use a password from the old SQL dump.
 */
function seed_demo_users(mysqli $conn): void
{
    $seedPassword = getenv('RAPID_RESCUE_SEED_PASSWORD');
    if ($seedPassword === false || $seedPassword === '') {
        return;
    }

    $users = [
        ['Admin', 'User', 'admin@rapidrescue.com', '1234567890', '1990-01-01', '123 Admin Street, City', 'admin'],
        ['John', 'Doe', 'john@example.com', '9876543210', '1985-05-15', '456 Main Street, City', 'user'],
        ['Jane', 'Smith', 'jane@example.com', '5555555555', '1992-08-20', '789 Oak Avenue, City', 'user'],
        ['Mike', 'Johnson', 'mike@example.com', '1111111111', '1988-12-10', '321 Pine Road, City', 'user'],
    ];

    $passwordHash = password_hash($seedPassword, PASSWORD_DEFAULT);
    if ($passwordHash === false) {
        throw new RuntimeException('Unable to hash the demo-user password.');
    }

    $check = $conn->prepare('SELECT userid FROM users WHERE email = ? LIMIT 1');
    $insert = $conn->prepare(
        'INSERT INTO users (firstname, lastname, email, phone, password, dob, address, role)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
    );

    if (!$check || !$insert) {
        throw new RuntimeException('Unable to prepare demo-user seeding statements.');
    }

    foreach ($users as $user) {
        [$firstname, $lastname, $email, $phone, $dob, $address, $role] = $user;
        $check->bind_param('s', $email);
        $check->execute();
        $exists = $check->get_result()->num_rows > 0;

        if (!$exists) {
            $insert->bind_param(
                'ssssssss',
                $firstname,
                $lastname,
                $email,
                $phone,
                $passwordHash,
                $dob,
                $address,
                $role
            );
            $insert->execute();
        }
    }

    $check->close();
    $insert->close();
}

seed_demo_users($conn);
