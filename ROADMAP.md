# Milestone 1 

Target version: 1.0.0

## Features: 
### CLI implementation
#### Create Group
- `create:class [options] className`
- `create:interface [options] className`
- `create:abstract [options] className`
- `create:trait [options] className`

#### Implement Group
- `extend:class [options] className implementationClassName`
- `extend:abstract [options] className implementationClassName`
- `implement:abstract [options] className implementationClassName`
- `implement:class [options] className implementationClassName`

#### Options for Create and Implement Groups: 
* --check-class-exists|-c  Check, that all usages classes available with autoload. 
* --default-path|-d     Path to generated files, when autoloader can't suggest anything for this namespace.  
* --parents|-p          List of parent classes (and interfaces).
* --overwrite|-w        Overwrite existing file on collision. 
* --output|-o           Target file or stream.

### API
#### Generator 
See `\FreeElephants\GeneralPi\GeneratorInterface` and related.

```
