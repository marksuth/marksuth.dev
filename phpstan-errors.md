 ------ ------------------------------------------------------------------------------------------------------------------------------------------------------------- 
Line   app/Http/Controllers/Backend/BaseBackendController.php
 ------ ------------------------------------------------------------------------------------------------------------------------------------------------------------- 
56     Method App\Http\Controllers\Backend\BaseBackendController::store() never returns Illuminate\Routing\Redirector so it can be removed from the return type.    
🪪  return.unusedType                                                                                                                                        
at app/Http/Controllers/Backend/BaseBackendController.php:56                                                                                                 
82     Method App\Http\Controllers\Backend\BaseBackendController::update() never returns Illuminate\Routing\Redirector so it can be removed from the return type.   
🪪  return.unusedType                                                                                                                                        
at app/Http/Controllers/Backend/BaseBackendController.php:82                                                                                                 
97     Method App\Http\Controllers\Backend\BaseBackendController::destroy() never returns Illuminate\Routing\Redirector so it can be removed from the return type.  
🪪  return.unusedType                                                                                                                                        
at app/Http/Controllers/Backend/BaseBackendController.php:97
 ------ ------------------------------------------------------------------------------------------------------------------------------------------------------------- 

 ------ ---------------------------------------------------------------------------------------------------------- 
Line   app/Http/Controllers/Backend/Traits/HandlesImageProcessing.php
 ------ ---------------------------------------------------------------------------------------------------------- 
13     Trait App\Http\Controllers\Backend\Traits\HandlesImageProcessing is used zero times and is not analysed.  
🪪  trait.unused                                                                                          
💡  See: https://phpstan.org/blog/how-phpstan-analyses-traits                                             
at app/Http/Controllers/Backend/Traits/HandlesImageProcessing.php:13
 ------ ---------------------------------------------------------------------------------------------------------- 

 ------ --------------------------------------------------------------------------------------------------- 
Line   app/Http/Controllers/Backend/Traits/HandlesMetadata.php
 ------ --------------------------------------------------------------------------------------------------- 
9      Trait App\Http\Controllers\Backend\Traits\HandlesMetadata is used zero times and is not analysed.  
🪪  trait.unused                                                                                   
💡  See: https://phpstan.org/blog/how-phpstan-analyses-traits                                      
at app/Http/Controllers/Backend/Traits/HandlesMetadata.php:9
 ------ --------------------------------------------------------------------------------------------------- 

 ------ --------------------------------------------------------------------------------------------------------- 
Line   app/Http/Controllers/Backend/Traits/HandlesSlugGeneration.php
 ------ --------------------------------------------------------------------------------------------------------- 
10     Trait App\Http\Controllers\Backend\Traits\HandlesSlugGeneration is used zero times and is not analysed.  
🪪  trait.unused                                                                                         
💡  See: https://phpstan.org/blog/how-phpstan-analyses-traits                                            
at app/Http/Controllers/Backend/Traits/HandlesSlugGeneration.php:10
 ------ --------------------------------------------------------------------------------------------------------- 

 ------ ------------------------------------------------------------------------------------------------------------------ 
Line   app/Http/Controllers/PostController.php
 ------ ------------------------------------------------------------------------------------------------------------------ 
72     Parameter #2 $year of method App\Http\Controllers\Controller::applyDateFilters() expects int|null, string given.  
🪪  argument.type                                                                                                 
at app/Http/Controllers/PostController.php:72
 ------ ------------------------------------------------------------------------------------------------------------------ 

 ------ -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
Line   app/Models/Note.php
 ------ -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
32     PHPDoc type array<int, string> of property App\Models\Note::$fillable is not covariant with PHPDoc type list<string> of overridden property Illuminate\Database\Eloquent\Model::$fillable.  
🪪  property.phpDocType                                                                                                                                                                     
💡  You can fix 3rd party PHPDoc types with stub files:                                                                                                                                     
💡  https://phpstan.org/user-guide/stub-files                                                                                                                                               
at app/Models/Note.php:32
 ------ -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

 ------ -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
Line   app/Models/Page.php
 ------ -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
34     PHPDoc type array<int, string> of property App\Models\Page::$fillable is not covariant with PHPDoc type list<string> of overridden property Illuminate\Database\Eloquent\Model::$fillable.  
🪪  property.phpDocType                                                                                                                                                                     
💡  You can fix 3rd party PHPDoc types with stub files:                                                                                                                                     
💡  https://phpstan.org/user-guide/stub-files                                                                                                                                               
at app/Models/Page.php:34
 ------ -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

 ------ --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
Line   app/Models/Photo.php
 ------ --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
36     PHPDoc type array<int, string> of property App\Models\Photo::$fillable is not covariant with PHPDoc type list<string> of overridden property Illuminate\Database\Eloquent\Model::$fillable.  
🪪  property.phpDocType                                                                                                                                                                      
💡  You can fix 3rd party PHPDoc types with stub files:                                                                                                                                      
💡  https://phpstan.org/user-guide/stub-files                                                                                                                                                
at app/Models/Photo.php:36
 ------ --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

 ------ -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
Line   app/Models/Post.php
 ------ -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
40     PHPDoc type array<int, string> of property App\Models\Post::$fillable is not covariant with PHPDoc type list<string> of overridden property Illuminate\Database\Eloquent\Model::$fillable.  
🪪  property.phpDocType                                                                                                                                                                     
💡  You can fix 3rd party PHPDoc types with stub files:                                                                                                                                     
💡  https://phpstan.org/user-guide/stub-files                                                                                                                                               
at app/Models/Post.php:40
 ------ -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 

 ------ ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Line   app/Models/PostCollection.php
 ------ ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
42     PHPDoc type array<int, string> of property App\Models\PostCollection::$fillable is not covariant with PHPDoc type list<string> of overridden property Illuminate\Database\Eloquent\Model::$fillable.  
🪪  property.phpDocType                                                                                                                                                                               
💡  You can fix 3rd party PHPDoc types with stub files:                                                                                                                                               
💡  https://phpstan.org/user-guide/stub-files                                                                                                                                                         
at app/Models/PostCollection.php:42
 ------ ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 

 ------ ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
Line   app/Models/PostType.php
 ------ ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
49     PHPDoc type array<int, string> of property App\Models\PostType::$fillable is not covariant with PHPDoc type list<string> of overridden property Illuminate\Database\Eloquent\Model::$fillable.  
🪪  property.phpDocType                                                                                                                                                                         
💡  You can fix 3rd party PHPDoc types with stub files:                                                                                                                                         
💡  https://phpstan.org/user-guide/stub-files                                                                                                                                                   
at app/Models/PostType.php:49                                                                                                                                                                   
89     Call to an undefined method Illuminate\Database\Eloquent\Builder<App\Models\Post>::belongsTo().                                                                                                 
🪪  method.notFound                                                                                                                                                                             
at app/Models/PostType.php:89
 ------ ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 

 ------ -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
Line   app/Models/User.php
 ------ -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
46     PHPDoc type array<int, string> of property App\Models\User::$fillable is not covariant with PHPDoc type list<string> of overridden property Illuminate\Database\Eloquent\Model::$fillable.  
🪪  property.phpDocType                                                                                                                                                                     
💡  You can fix 3rd party PHPDoc types with stub files:                                                                                                                                     
💡  https://phpstan.org/user-guide/stub-files                                                                                                                                               
at app/Models/User.php:46                                                                                                                                                                   
57     PHPDoc type array<int, string> of property App\Models\User::$hidden is not covariant with PHPDoc type list<string> of overridden property Illuminate\Database\Eloquent\Model::$hidden.      
🪪  property.phpDocType                                                                                                                                                                     
💡  You can fix 3rd party PHPDoc types with stub files:                                                                                                                                     
💡  https://phpstan.org/user-guide/stub-files                                                                                                                                               
at app/Models/User.php:57
 ------ -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
