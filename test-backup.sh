#!/bin/bash

# Test the backup functionality
echo "Testing backup functionality..."

# Run the backup:clean command
echo "Running backup:clean command..."
php artisan backup:clean

# Run the backup:run command
echo "Running backup:run command..."
php artisan backup:run

# List all backups
echo "Listing all backups..."
php artisan backup:list

echo "Backup test completed."
