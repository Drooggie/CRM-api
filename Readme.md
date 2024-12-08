## Installation and setup 

Clone Repository 
```
git clone https://github.com/Drooggie/CRM-api.git
``` 

Move into Repository 
```
cd CRM-api
``` 


Run this command for building and starting containers
```
docker compose up -d --build && docker compose logs -f app
```  

Then you can see your app in <a href="http://localhost:8888/"> localhost:8888</a>
<br />
<br />

## Commands
I manually created command for module manipulation. You can exec theme for creating new modules. Here is structure of this command.
```
php artisan make:module {name} {folder} --all
```
`name`, `folder` and third argument are necessary for results. All created files will be stored in `Modules` folder and `folder` argument creates name of the folders that will contain everything created by command. Third arguments changeable and defines creation of all module or part of it. Here is available options: <br />
`--all=[all, web]` - creates everything and defines type of routes<br />
`--routes=[all, web]` - creates routes, types defined by value assigned to it, available options: [all, web] <br />
`--model` - creates model <br />
`--migration` - creates migration <br />
`--controller` - creates controller <br />

