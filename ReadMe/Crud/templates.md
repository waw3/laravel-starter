## Custom Templates

The package allows user to extensively customize or use own templates.

### All Templates

To customize or change the template, you need to follow these steps:


1. To override the default template with yours, turn on `custom_template` option in the `config/crudgenerator.php` file.
    ```php
    'custom_template' => true,
    ```

2. Now you can customize everything from this `resources/stubs/crud` directory.

3. Even if you need to use any custom variable just add those in the `config/crudgenerator.php` file.

### Form Helper

You can use any form template for your forms. In order to do that, you just need to mention the helper package name while generating the main CRUD or views with this option `--form-helper`. This generator use `blade` as default helper.

To use the any other form helper, you need to follow these steps:

1. Make sure you've installed & configured the desire helper package.

2. For use custom helper template, you should turn on `custom_template` option in the `config/crudgenerator.php` file.

3. Now put your files into `resources/stubs/crud/views/` directory. Suppose your helper is `custom-template` then you should create a directory as `resources/stubs/crud/views/custom-template`. You can also copy the template files from other helper directory, then modify as yours.

4. You're ready to generate the CRUD with your helper.
    ```
    php artisan crud:generate Posts --fields='title#string; content#text; category#select#options={"technology": "Technology", "tips": "Tips", "health": "Health"}' --view-path=admin --controller-namespace=Admin --route-group=admin --form-helper=custom-template
    ```

[&larr; Back to index](README.md)
