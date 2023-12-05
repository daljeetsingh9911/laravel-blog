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

.
├── Artical.php
├── Category.php
├── Tag.php
└── User.php

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
