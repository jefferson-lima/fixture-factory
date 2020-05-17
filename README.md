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

### Symfony constraints

It's also possible to use [Symfony validation constraints](https://symfony.com/doc/current/reference/constraints.html#basic-constraints)
to narrow down the values generated for your properties. Here is a list of the currently
supported annotations:

Strings:

- [NotBlank](https://symfony.com/doc/current/reference/constraints/NotBlank.html)
- [Length](https://symfony.com/doc/current/reference/constraints/Length.html)




## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details