# Developer's Guide

Merchant CLI development guide! This document outlines the development workflow and best practices for contributing to the project.

## Before We Start

Merchant CLI uses Laravel Zero framework, so read [Laravel Zero Docs](https://laravel-zero.com/docs/introduction)

## Branching Strategy

### Branch Structure
- `master`: Production-ready code. This branch should aways be stable and deployable. 
- `dev`: Development branch where all features are integrated before merging to main. 
- `feature/*`: Feature branches for new functionality (e.g., `feature/upgrade-building-command`, `feature/market-scan-command`). 
- `bugfix/*`: Bug fix branches (e.g., `bugfix/game-status-crash`, `bugfix/game-init-not-working`). 
- `hotfix/*`: Critical fixes that need to go directly to main.

### Important Rules

⚠️ **NEVER commit directly to the `master` branch!**

- All changes must go through the `dev` branch first
- Create feature branches from `dev`
- Merge features branches back to `dev`
- Only merge `dev` to `master` after testing

## Development Workflow

### 1. Setting Up Development Environment

```bash
# Clone the repository
git clone https://github.com/deivao06/merchant-cli.git
cd merchant-cli

# Switch to dev branch
git checkout dev
```
#### Docker

```bash
# Start docker container
cd docker
docker compose up -d
```

#### Install dependencies

```bash
# Using docker
docker exec -it merchant-cli composer install

# Or use local installed composer
composer install
```

### 2. Creating a New Feature

```bash
# Start from the latest dev branch
git checkout dev
git pull origin dev

# Create a new feature branch
git checkout -b feature/your-feature-name

# Make your changes...

# Commit your changes
git add .
git commit -m "feat: your feature description"

# Push your feature branch
git push origin feature/your-feature-name
```

### 3. Submitting Changes

1. Create a Pull Request from your feature branch to `dev`
2. Ensure all tests pass
3. Request code review from maintainers
4. Address any feedback
5. Merge to `dev` after approval

## Testing

[Laravel Zero Testing Guide](https://laravel-zero.com/docs/testing)

### Test File Organization
- Test files name should always end with `Test` (e.g., `GameInitCommandTest`, `GameEngineTest`)

### Running Tests

```bash
# Using docker container
docker exec -it merchant-cli php merchant-cli test

# Or outside docker container
php merchant-cli test 

# Or using pest command
./vendor/bin/pest
```

### Creating Tests

```bash
# Using docker container
docker exec -it merchant-cli php merchant-cli make:test MyNewFeatureTest

# Or outside docker container
php merchant-cli make:test MyNewFeatureTest
```

## Building

[Laravel Zero Building as PHAR archive](https://laravel-zero.com/docs/distribute-as-a-phar-archive)

### Local Development Build
```bash
# Using docker container
docker exec -it merchant-cli php merchant-cli app:build merchant-cli
```

## Commit Message Format

Use conventional commit format:

```bash
type(scope): description

[optional body]

[optional footer]
```

Types:

- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes
- `refactor`: Code refactoring
- `test`: Adding or updating tests
- `chore`: Maintenance tasks

Examples:

```bash
feat(resources): add new resource type
fix(city): city json serialization
docs(readme): update installation instructions
```
