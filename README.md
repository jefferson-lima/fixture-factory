# Fixture Factory

Generates fixture objects to be used in tests.

## Installation

```
composer require jefferson-lima/fixture-factory
```

## Usage

Fixture Factory uses the metadata of your class properties to generate values for them. The value generated for a
property is derived from its `@var` tag. Thus, first you must annotate your properties with their types:

```
MyClass {

  /** @var string */
  public $foo;

  public $bar;
}
```

The properties without a `@var` tag, or with and invalid one, will be ignored. 

Then you can use the `FixtureFactory` to create a fixture for your class: 

```
$myFixture = FixtureFactory::createFixture(MyClass::class);
```

Fixture Factory uses [Faker](https://github.com/fzaninotto/Faker) to generate values.

### Supported types

Currently, the supported types are `string`, `int`, `bool`, `float`. Objects are supported, as long
as a concrete class is provided. Abstract classes or interfaces are not supported as it's not possible
to determine the concrete implementation that should be used. 
Nested objects will be generated recursively.

### Overriding attributes

It's possible to override attributes by passing an array as a second argument to the `createFixture`
method:

```
$myFixture = FixtureFactory::createFixture(MyClass::class, ['foo' => 'bar']);
```

### Circular references

Care must be taken with circular references,
they must be avoided or overridden, otherwise an exception will be thrown. One example of circular
reference is shown below:

```
class Foo {
  /** @var Bar */
  private $bar;
}

class Bar {
  /** @var Foo */
  private $foo;
}
```

A circular reference can be broken by overriding one attribute:

```
$myFixture = FixtureFactory::createFixture(MyClass::class, ['bar' => null]);
```

Doctrine annotations can also be used to resolve circular references, for example:

```
class Foo {
  /**
   * @var Bar
   * @OneToOne(targetEntity="Bar", inversedBy="foo")
   */
  private $bar;
}

class Bar {
  /**
   * @var Foo
   * @OneToOne(targetEntity="Foo", mappedBy="bar")
   */
  private $foo;
}
```

In this case, it's possible to identify that `foo` points to `bar`, and that `bar` points back
at it.

### Symfony constraints

It's also possible to use [Symfony validation constraints](https://symfony.com/doc/current/reference/constraints.html#basic-constraints)
to narrow down the values generated for your properties. These are the currently supported constraints
listed by order of precedence:

Strings:
- [@Regex](https://symfony.com/doc/current/reference/constraints/Regex.html)
- [@Uuid](https://symfony.com/doc/current/reference/constraints/Uuid.html)
- [@Email](https://symfony.com/doc/current/reference/constraints/Email.html)
- [@Url](https://symfony.com/doc/current/reference/constraints/Url.html)
- [@Date](https://symfony.com/doc/current/reference/constraints/Date.html)
- [@DateTime](https://symfony.com/doc/current/reference/constraints/DateTime.html)
- [@Choice](https://symfony.com/doc/current/reference/constraints/Choice.html)
- [@Length](https://symfony.com/doc/current/reference/constraints/Length.html)
- [@NotBlank](https://symfony.com/doc/current/reference/constraints/NotBlank.html)

Numbers:
- [@Positive](https://symfony.com/doc/current/reference/constraints/Positive.html)
- [@Negative](https://symfony.com/doc/current/reference/constraints/Negative.html)

Some constraints can't be applied simultaneously. In this case, the constraint with higher precedence
 is applied. For example:

```
/**
 * @Length(min=255)
 * @Email
 */
private $email;
```

In this case, the `@Email` constraint is applied, and the `@Length` will be ignored. 

### Doctrine Associations

The following Doctrine associations are supported:

- [@OneToOne](https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/reference/association-mapping.html#one-to-one-unidirectional) unidirectional and bidirectional
- [@OneToMany](https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/reference/association-mapping.html#one-to-many-unidirectional-with-join-table) unidirectional

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details