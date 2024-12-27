# Laravel CRUD Generator

This package is a Laravel CRUD generator that will generate CRUD code for you simply. This package will reduce the time to create a module in Laravel.

It generates the following code:

- Model
- Controller
- Store and Update Request
- Resource

# Installation

1. Run

```bash
composer require kemboielvis/laravel-crud-generator --dev
```

2. To generate Code for specefic model

   > The model name should be inside the `App/Models` Directory

   > For the CRUD to be generated fill out the fillables then run the command below

```shell
php artisan crud:generate {ModelName}
```

3. Generate code for all model in `App/Models/**`
   > For the crud to be generated fill out all the fillables then run the command below
   ```shell
   php artisan crud:generate
   ```

The code will be generated in the following directories:

- Controllers: `App/Http/Controllers`
- StoreRequest: `App/Http/Requests/{ModelName}/StoreRequest.php`
- UpdateRequest: `App/Http/Requests/{ModelName}/UpdateRequest.php`
- Resource: `App/Http/Resources/{ModelName}/{ModelName}Resource.php`

## Warning

When using this code generator you should be careful because it will overwrite the existing files and written code

# License

The Laravel CRUD Generator is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# For new Features and Bugs and Suggestions

If you have any new features or bugs you can create an issue or create a pull request.
