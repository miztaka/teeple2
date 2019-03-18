# Teeple2

## Introduction

`teeple2` is a MVC framework with PHP5 which is inspired by [seasar2](http://www.seasar.org/en/).

- Low cost to learn. (less convention, simple)
- Auto-generationg controller classes
- No conficuration of routing.
- Validation with no coding.
- Converter with no coding.
- Easy Active Record framework with method chain architecture.
- Filter architecture similar to Java Servlet.
- Simple architecture with DI (Dependency Injection) container.
- Optimize to enable code assist with eclipse.

## Highlight

### List and search

```
class Example_Search extends Teeple_ActionBase {

// Search results of employee with user input.

  public function doSearch() {

    $this->searchResults = Entity_Employee::get()
      ->contains('name', $this->name)
      ->contains('name_kana', $this->name_kana)
      ->limit($this->limit)
      ->offset($this->offset)
      ->order('employee_no ASC')
      ->select();

    return '/example/search.html';
  }
}
```

### Create new record

```
class Example_Create extends Teeple_ActionBase {

  // Save new employee to the Database.

  public function doCreate() {

    $entity = Entity_Employee::get();
    $entity->convert2Entity($this); // Copy values of a form to the model instance.
    $entity->insert();

    return '/example/create.html';
  }
}
```

### Update record

```
class Example_Update extends Teeple_ActionBase {

  // Update employee's information with user input.

  public function doUpdate() {

    $entity = Entity_Employee::get()->find($this->id);
    $entity->convert2Entity($this);
    $entity->update();

    return '/example/update.html';
  }
}
```

### Show record

```
class Example_Read extends Teeple_ActionBase {

  // Show an employee information of specified ID.

  public function execute() {

    $entity = Entity_Employee::get()->find($this->id);
    $entity->convert2Page($this); // Copy data of entity to the page.

    return '/example/read.html';
  }
}
```

