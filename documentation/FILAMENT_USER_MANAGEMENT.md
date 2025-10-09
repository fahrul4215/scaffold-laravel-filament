# Filament User Management with Roles

This document describes the advanced user management system with roles that has been implemented in this Laravel Filament application.

## Features Implemented

### 1. **User Management**

- Complete CRUD operations for users in a single-page interface
- Modal-based create and edit forms
- Role assignment interface with multi-select
- Email verification tracking
- Password management with proper hashing
- User filtering by roles and verification status
- Searchable and sortable user lists
- Quick actions (view, edit, delete) directly from the table

### 2. **Role Management**

- Complete CRUD operations for roles in a single-page interface
- Modal-based create and edit forms
- Permission assignment to roles
- View users count per role
- Guard name management
- Protection against deleting critical roles (superadmin)

### 3. **Authorization & Security**

- Role-based access control using policies
- Superadmin has full access to all features
- Admin can manage users and view roles
- Editor can view and edit users
- Viewer has read-only access
- Protection against self-deletion
- Hierarchical permission system

### 4. **Pre-configured Roles**

The system comes with 4 pre-configured roles:

#### Superadmin

- Full access to everything
- Can manage users, roles, and permissions
- Cannot be deleted

#### Admin

- Can view, create, edit, and delete users
- Can view roles
- Cannot modify roles or permissions

#### Editor

- Can view and edit users
- No access to roles or permissions

#### Viewer

- Can view users and roles
- Read-only access

## Resource Type

Both User and Role resources are implemented as **Simple Resources** (single-page resources):

- All operations happen on one page
- Create and edit forms open in modals
- No separate pages for create/edit/view
- More streamlined and modern UX
- Faster navigation and less page loads

## Database Structure

### Tables Created
- `roles` - Stores role information
- `permissions` - Stores permission information
- `model_has_roles` - Links users to roles
- `model_has_permissions` - Links users to permissions
- `role_has_permissions` - Links roles to permissions

## Default Credentials

### Superadmin User
- **Email:** admin@admin.com
- **Password:** password

⚠️ **Important:** Change the default password after first login!

## File Structure

### Resources

```
app/Filament/Resources/
├── Users/
│   ├── UserResource.php
│   ├── Pages/
│   │   └── ManageUsers.php (single page for all operations)
│   ├── Schemas/
│   │   ├── UserForm.php
│   │   └── UserInfolist.php
│   └── Tables/
│       └── UsersTable.php
└── Roles/
    ├── RoleResource.php
    ├── Pages/
    │   └── ManageRoles.php (single page for all operations)
    ├── Schemas/
    │   ├── RoleForm.php
    │   └── RoleInfolist.php
    └── Tables/
        └── RolesTable.php
```

### Policies
```
app/Policies/
├── UserPolicy.php - Controls access to user management
└── RolePolicy.php - Controls access to role management
```

### Seeders
```
database/seeders/
├── RoleSeeder.php - Creates default roles and permissions
├── SuperAdminSeeder.php - Creates superadmin user
└── DatabaseSeeder.php - Orchestrates seeding
```

## Usage

### Accessing the Admin Panel

1. Navigate to `/admin` in your browser
2. Login with the superadmin credentials
3. You'll see two navigation items under "User Management":
   - **Users** - Manage all users
   - **Roles** - Manage roles and permissions

### Creating a New User

1. Go to Users page
2. Click the "Create" button (top right)
3. Fill in the user information in the modal form
4. Select roles to assign
5. Click "Create" to save the user

### Editing a User

1. Click the "Edit" icon (pencil) on any user row
2. Update the user information in the modal form
3. Click "Save changes"

### Managing Roles

1. Go to Roles page
2. Click "Create" to add a new role or "Edit" to modify existing roles
3. Assign permissions to roles
4. View how many users have each role in the "Users" column

### Assigning Roles to Users

1. Click the "Edit" icon on a user
2. In the "Roles & Permissions" section, select one or more roles
3. Click "Save changes"

## Permissions Available

- `view users` - Can view user list
- `create users` - Can create new users
- `edit users` - Can edit existing users
- `delete users` - Can delete users
- `view roles` - Can view role list
- `create roles` - Can create new roles
- `edit roles` - Can edit existing roles
- `delete roles` - Can delete roles

## Security Features

1. **Password Hashing**: All passwords are automatically hashed using bcrypt
2. **Self-Protection**: Users cannot delete themselves
3. **Role Hierarchy**: Admins cannot modify superadmin users
4. **Policy-Based Authorization**: All actions are checked against policies
5. **Email Uniqueness**: Each email can only be used once
6. **Password Update Protection**: Blank passwords are ignored during updates

## Customization

### Adding New Roles
Run the following in tinker or create a migration:
```php
use Spatie\Permission\Models\Role;
$role = Role::create(['name' => 'custom-role']);
```

### Adding New Permissions
```php
use Spatie\Permission\Models\Permission;
$permission = Permission::create(['name' => 'custom-permission']);
```

### Assigning Permissions to Roles
```php
$role->givePermissionTo('permission-name');
// or
$role->syncPermissions(['permission1', 'permission2']);
```

## Re-seeding

If you need to re-seed roles and permissions:
```bash
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=SuperAdminSeeder
```

Or seed everything:
```bash
php artisan db:seed
```

## Package Used

- **spatie/laravel-permission** (v6.21.0) - For roles and permissions management
- Documentation: https://spatie.be/docs/laravel-permission/

## Notes

- The User model has been updated to use the `HasRoles` trait
- The User model implements `FilamentUser` interface for panel access
- All policies are registered in `AppServiceProvider`
- Role and permission caching is handled by the Spatie package
- Clear cache if permissions don't seem to work: `php artisan cache:clear`
