Audit Log for LaravelA simple Laravel package to track model changes (create, update, delete) with a comprehensive audit log.🚀 InstallationYou can install the package via Composer:composer require kishan/audit-log
For Laravel < 5.5If you're using Laravel 5.4 or older, you must manually add the service provider in config/app.php:'providers' => [
    Kishan\AuditLog\AuditLogServiceProvider::class,
];
⚙️ Setup and ConfigurationAfter installation, you need to publish the migration file and run the database migrations.php artisan vendor:publish --provider="Kishan\AuditLog\AuditLogServiceProvider" --tag="migrations"
php artisan migrate
If you'd like to customize the settings, you can also publish the config file:php artisan vendor:publish --provider="Kishan\AuditLog\AuditLogServiceProvider" --tag="config"
💡 Usage1. Add the Trait to Your ModelTo start logging activity for a specific model, just add the LogsActivity trait.use Illuminate\Database\Eloquent\Model;
use Kishan\AuditLog\Traits\LogsActivity;

class Post extends Model
{
    use LogsActivity;

    protected $fillable = ['title', 'content'];
}
2. Retrieve All LogsYou can easily access all the logged activities through the AuditLog model.use Kishan\AuditLog\Models\AuditLog;

$logs = AuditLog::all();
3. Advanced LoggingFor more control, you can manually log events with a fluent interface. This lets you specify the user who caused the action, add custom properties, and write a custom description.activity()
    ->performedOn($post) // The Eloquent model the action was performed on
    ->causedBy(auth()->user()) // The user who triggered the action
    ->withProperties(['customProperty' => 'customValue']) // Extra data
    ->log('Post was updated');
The AuditLog model provides several useful properties to access this data:$lastActivity = \Kishan\AuditLog\Models\AuditLog::all()->last();

$lastActivity->subject;        // returns the Post model
$lastActivity->causer;         // returns the User model
$lastActivity->changes;        // returns an array of old and new attribute values
$lastActivity->description;    // "Post was updated"
4. Automatic Event LoggingWhen you use the LogsActivity trait, changes (creates, updates, and deletes) are logged automatically.$post->title = 'Updated title';
$post->save();

// This automatically logs changes
$activity = \Kishan\AuditLog\Models\AuditLog::all()->last();

$activity->description; // "updated"
$activity->changes;     // shows old and new values
✅ TestingTo run the test suite, just use the composer test command.composer test
🤝 ContributingContributions, issues, and feature requests are welcome! Feel free to fork this repository and submit a pull request.
