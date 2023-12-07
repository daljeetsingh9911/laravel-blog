## Relationship

# one to Many

one user can have multiple Articles 
```
  $table->foreignId('user_id')
                    ->constrained('users')
                    ->cascadeOnDelete();  // if user will be deleted all the articles related to user_id will be deleted
```

one category can have multiple Articles

```
$table->foreignId('category_id')
                  ->constrained('categories')
                  ->cascadeOnDelete(); // if category deleted all the articles related to category will be deleted
```

# Many to Many Relationship

IN THE TAGS CASE one tag have multiple articles and one article can have multiple Tag

"To resolve this issue we will use pivot table "

What is pivot table [click her](https://medium.com/@miladev95/laravel-pivot-table-15c69d517a83) to learn more

so in over case create a migrate to create a ”Pivot table”

php artisan make:migration ”create_article_tag_table”  

Must use this naming convention for the ”Pivot Table”  Create_{table1}_{table2}_table

```
Each migration should have in order wise otherwise you will get into an error

for example

we have foreignKey in article on Categories and tags

so Categories and tags table must be migrate first before article Table

```

## Setting Up Relationship in Model

in the case of Articles 

A Single Article is blongs to tags ,categories and users

so we have made Relationship between these in Article Model


”The name of the Method  is depends on the Relationship type as following”
<pre>
  Models
.
├── Artical.php
├── Category.php
├── Tag.php
└── User.php
</pre>

```
Artical.php

//....Code 
  public function user():BelongsTo{  // a single Article blongs single user 
      return $this->belongsTo(User::class,'user_id');
  }

  public function category(): BelongsTo{ // A single Artical is belongsTo Single Category
      return $this->belongsTo(Category::class,'category_id');
  }

  public function tags():BelongsToMany{ // A Single Artical can have multiple tags and tags and A single tag can have multiple Articles links to it.
      return $this->belongsToMany(Tag::class);

  }
//----Rest Code

```



```
Category.php

//--- rest code 


public function articles():HasMany {  // A Single Categories can have multiple articles allocated
  return $this->hasMany(Article::class);
}
//--- rest code 


```

```
Tag.php

//--- rest code 
public function articles():BelongsToMany{ // A single Tag blongs to many Articles
    return $this->belongsToMany(Article::class); 
}
//--- rest code 


```

## Mitigations, seeding and  Factories 
so everything comes under the database folder

we have

<pre>
├── data
│   └── categories.json    // we load all the cartegories from here 
├── factories       // Factories will help us to create fake content inside database tables
│   ├── ArticleFactory.php
│   ├── TagFactory.php
│   └── UserFactory.php
├── migrations        // Migrations will hold all the table structure or table details                                                 
│   ├── 2014_10_12_000000_create_users_table.php
│   ├── 2014_10_12_100000_create_password_reset_tokens_table.php
│   ├── 2019_08_19_000000_create_failed_jobs_table.php
│   ├── 2019_12_14_000001_create_personal_access_tokens_table.php
│   ├── 2023_12_05_092950_create_tags_table.php
│   ├── 2023_12_05_101123_create_categories_table.php
│   ├── 2023_12_05_101125_create_articles_table.php
│   └── 2023_12_05_101126_create_article_tag_table.php
└── seeders     // help us to seed the fake insertions of data
    ├── CategorySeeder.php
    └── DatabaseSeeder.php

</pre>


Commands:
```
php artisan migrate // to create table inside database

for migration the order of migrations will always matters

//All Seeders
php artisan db:seed
//One Seeder
php artisan db:seed --class=NameSeeder

```
if you run  `php artisan db:seed`

the main class for seeding is DatabaseSeeder.php


```

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CategorySeeder::class); // calling category seeder
        User::factory()->count(10)->create(); // creating 10 user 
        Article::factory() 
                ->has(Tag::factory()->count(2))  // beacuse we have pivot table relationshio ManytoMany
                ->count(50)
                ->create();
    }
}

```

## Creating Request  handler

```
php artisan make:request NAME_OF_REQUEST_CLASS
```
the request class we can handle validations

For Example

```
class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array 
    { 
        return [
            'name' => ['required','string','max:255','unique:articles'],
            'excerpt' => ['required','string'],
            'description' => ['required','string'],
            'category_id' => ['required','exists:categories,id'],
            'tags' => ['nullable','array'],
            'tags.*' => ['integer',Rule::exists('tags','id')],
        ];
    }
}

```
'unique:articles' will check form database it the name and slug is unique as we set in migration 

'exists:categories,id' will check if the category id is exists in the categories table
<pre> 

{ 
'tags' => ['nullable','array'], will check is the tag are request input should be array of nullable
'tags.*' => ['integer',Rule::exists('tags','id')], // there it
}
'tags.*' means [tagID1,tagID2,tagID3] for each tagID

['integer',Rule::exists('tags','id')] value should be integer and it should exist inside tags table
</pre>
