# Audit Log for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kishan/audit-log.svg?style=flat-square)](https://packagist.org/packages/kishan/audit-log)
[![Total Downloads](https://img.shields.io/packagist/dt/kishan/audit-log.svg?style=flat-square)](https://packagist.org/packages/kishan/audit-log)

A simple Laravel package to track model changes (create, update, delete) with an audit log.

---

## Installation

You can install the package via Composer:

```bash
composer require kishan/audit-log

## Service Provider (for Laravel < 5.5)

If you are using Laravel 5.4 or lower, add the service provider manually in config/app.php:


'providers' => [
    Kishan\AuditLog\AuditLogServiceProvider::class,
];

## ⚙️ Publish & Migrate
Publish the migration and run the database migrations:


php artisan vendor:publish --provider="Kishan\AuditLog\AuditLogServiceProvider" --tag="migrations"
php artisan migrate

(Optional) Publish the config file if you want to customize settings:
php artisan vendor:publish --provider="Kishan\AuditLog\AuditLogServiceProvider" --tag="config"

🛠 Usage
1. Add trait to your model
use Illuminate\Database\Eloquent\Model;
use Kishan\AuditLog\Traits\LogsActivity;

class Post extends Model
{
    use LogsActivity;

    protected $fillable = ['title', 'content'];
}
2. Retrieve all logs
use Kishan\AuditLog\Models\AuditLog;

$logs = AuditLog::all();

3. Advanced logging example
activity()
    ->performedOn($post) // Eloquent model
    ->causedBy(auth()->user()) // The user who triggered the action
    ->withProperties(['customProperty' => 'customValue']) // Extra data
    ->log('Post was updated');

$lastActivity = \Kishan\AuditLog\Models\AuditLog::all()->last();

$lastActivity->subject;        // returns the Post model
$lastActivity->causer;         // returns the User model
$lastActivity->changes;        // returns changed attributes
$lastActivity->description;    // "Post was updated"

4. Example on event logging
$post->title = 'Updated title';
$post->save();

// This automatically logs changes
$activity = \Kishan\AuditLog\Models\AuditLog::all()->last();

$activity->description; // "updated"
$activity->changes;     // shows old and new values

✅ Testing

Run the tests with:
composer test

🤝 Contributing

Contributions, issues, and feature requests are welcome!
Feel free to fork this repo and submit a pull request.



