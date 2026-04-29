<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * USER ATTRIBUTES
     * $this->attributes['id'] - integer - contains the user primary key (id)
     * $this->attributes['name'] - string - contains the user full name
     * $this->attributes['email'] - string - contains the user email address
     * $this->attributes['password'] - string - contains the hashed user password
     * $this->attributes['address'] - string - contains the user address
     * $this->attributes['phone'] - string - contains the user phone number
     * $this->attributes['role'] - string - contains the user role (admin or customer)
     * $this->attributes['budget'] - integer - contains the user available budget
     * $this->attributes['created_at'] - timestamp - contains the user creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the user update timestamp
     *
     * USER RELATIONSHIPS
     * $this->orders - HasMany - contains the related Orders
     * $this->reviews - HasMany - contains the related Reviews
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'role',
        'budget',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* Getters - Attributes */
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getEmail(): string
    {
        return $this->attributes['email'];
    }

    public function getPassword(): string
    {
        return $this->attributes['password'];
    }

    public function getAddress(): string
    {
        return $this->attributes['address'];
    }

    public function getPhone(): string
    {
        return $this->attributes['phone'];
    }

    public function getRole(): string
    {
        return $this->attributes['role'];
    }

    public function getBudget(): int
    {
        return $this->attributes['budget'] ?? 0;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    /* Formatted Getters */
    public function getBudgetFormatted(): string
    {
        return '$' . number_format($this->getBudget(), 0, ',', ' ');
    }

    /* Setters - Attributes */
    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function setEmail(string $email): void
    {
        $this->attributes['email'] = $email;
    }

    public function setPassword(string $password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function setAddress(string $address): void
    {
        $this->attributes['address'] = $address;
    }

    public function setPhone(string $phone): void
    {
        $this->attributes['phone'] = $phone;
    }

    public function setRole(string $role): void
    {
        $this->attributes['role'] = $role;
    }

    public function setBudget(int $budget): void
    {
        $this->attributes['budget'] = $budget;
    }

    /* Getters - Relationships */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    protected function casts(): array
    {
        return [
            'budget' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* Relationships */

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
