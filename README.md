# laravel-model-export

A lightweight Laravel package to export Eloquent model data to CSV, with support for low-memory, lazy exports and a clean API via an `Exportable` trait and query macro.

## 📦 Features

- Export model data to CSV using a simple method call
- Export via query chaining (`User::where(...)->exportToCsv()`)
- Automatically uses the model's `$exportable` property
- Low memory usage via `lazyById()`
- Customizable export paths

---

## 🚀 Installation

```bash
composer require your-vendor/laravel-exportable
```

If you're using Laravel <10, you may need to manually register the service provider in config/app.php:

```bash
YourVendor\Exportable\ExportableServiceProvider::class,
```

### 🛠 Usage
Export all records (static call)

```php
User::exportToExcel(); // uses default filename and $exportable columns
```

### Export filtered data via query

``
User::where('active', true)
    ->orderBy('name')
    ->exportToExcel(); // exports only active users
``

### Export to custom path

``
User::exportToExcel(storage_path('exports/users.csv'));
``

📁 File Output
Files are exported to /storage/app by default unless a custom path is provided.

Filenames follow this format:
export_ModelName_TIMESTAMP.csv

### Export to browser

``
User::streamDownload();
``

### 🧠 How It Works
- The Exportable trait adds a static exportToCsv() method for convenience.

- A macro is registered on Eloquent\Builder so that you can chain ->exportToCsv() on queries.

- Columns are read from the $exportable property on the model.

- Under the hood, Spatie’s SimpleExcelWriter handles the CSV generation.

- Memory-efficient thanks to Laravel’s lazyById().
