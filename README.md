Slim-Controllers
================

### Usage

```php
$app = new Controller\Application();

$blog = $app->controller_factory;
$blog->get('/', funnction () {
    return "Hello World, I am Blog Home";
});
$blog->get('/posts', funnction () {
    return "These are my posts";
});

$people = $app->controller_factory;
$people->get('/', function () {
    return 'Where my people's at?';
});

$app->mount('/blog', $blog);
$app->mount('/people', $people);
```