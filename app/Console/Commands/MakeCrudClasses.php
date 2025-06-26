<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeCrudClasses extends Command
{
    protected $signature = 'make:crud {model}';
    protected $description = 'Generate Repository, Service, Controller, Request, and Resource for a model';

    final public function handle(): void
    {
        $model = Str::studly($this->argument('model'));
        $filesystem = new Filesystem();

        // Repository
        $repoPath = app_path("Http/Repositories/{$model}Repository.php");
        if (!$filesystem->exists($repoPath)) {
            $filesystem->put($repoPath, $this->getRepositoryStub($model));
            $this->info("Repository created: $repoPath");
        }

        // Service
        $servicePath = app_path("Http/Services/{$model}Service.php");
        if (!$filesystem->exists($servicePath)) {
            $filesystem->put($servicePath, $this->getServiceStub($model));
            $this->info("Service created: $servicePath");
        }

        // Controller
        $controllerPath = app_path("Http/Controllers/Api/{$model}Controller.php");
        if (!$filesystem->exists($controllerPath)) {
            $filesystem->put($controllerPath, $this->getControllerStub($model));
            $this->info("Controller created: $controllerPath");
        }

        // Read Request
        $readRequestPath = app_path("Http/Requests/Read{$model}Request.php");
        if (!$filesystem->exists($readRequestPath)) {
            $filesystem->put($readRequestPath, $this->getReadRequestStub($model));
            $this->info("Read Request created: $readRequestPath");
        }

        // Base Request
        $baseRequestPath = app_path("Http/Requests/Base{$model}Request.php");
        if (!$filesystem->exists($baseRequestPath)) {
            $filesystem->put($baseRequestPath, $this->getBaseRequestStub($model));
            $this->info("Base Request created: $baseRequestPath");
        }

        // Requests (Store, Update)
        foreach (["Store", "Update"] as $type) {
            $requestPath = app_path("Http/Requests/$type{$model}Request.php");
            if (!$filesystem->exists($requestPath)) {
                $filesystem->put($requestPath, $this->getRequestStub($model, $type));
                $this->info("Request created: $requestPath");
            }
        }

        // Resource
        $resourcePath = app_path("Http/Resources/{$model}Resource.php");
        if (!$filesystem->exists($resourcePath)) {
            $filesystem->put($resourcePath, $this->getResourceStub($model));
            $this->info("Resource created: $resourcePath");
        }
    }

    private function getRepositoryStub(string $model): string
    {
        $repository = $model . 'Repository';

        return <<<PHP
<?php

namespace App\Http\Repositories;

use App\Models\\$model;

class $repository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new $model());
    }
}
PHP;
    }

    private function getServiceStub(string $model): string
    {
        $repository = $model . 'Repository';
        $service = $model . 'Service';

        return <<<PHP
<?php

namespace App\Http\Services;

use App\Http\Repositories\\$repository;

class $service extends BaseService
{
    public function __construct(readonly protected $repository \$repository)
    {
    }
}
PHP;
    }

    private function getControllerStub(string $model): string
    {
        $resource = $model . 'Resource';
        $storeRequest = 'Store' . $model . 'Request';
        $updateRequest = 'Update' . $model . 'Request';
        $readRequest = 'Read' . $model . 'Request';
        $service = $model . 'Service';
        $controller = $model . 'Controller';

        return <<<PHP
<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\\$storeRequest;
use App\Http\Requests\\$updateRequest;
use App\Http\Requests\\$readRequest;
use App\Http\Resources\\$resource;
use App\Http\Services\\$service;

class $controller extends BaseApiController
{
    final protected function getService(): $service
    {
        return resolve($service::class);
    }

    final protected function getRequestClass(string \$method): string
    {
        return match (\$method) {
            'store' => $storeRequest::class,
            'update' => $updateRequest::class,
            'index' => $readRequest::class,
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getResourceClass(): string
    {
        return $resource::class;
    }
}
PHP;
    }

    private function getRequestStub(string $model, string $type): string
    {
        $typeModelRequest = $type . $model . 'Request';
        $baseModelRequest = "Base{$model}Request";
        return <<<PHP
<?php

namespace App\Http\Requests;

class $typeModelRequest extends $baseModelRequest
{
    // You can override rules() or authorize() if needed
}
PHP;
    }

    private function getReadRequestStub(string $model): string
    {
        $request = 'Read' . $model . 'Request';
        return <<<PHP
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class $request extends FormRequest
{
    final public function rules(): array
    {
        return [
            //
        ];
    }
}
PHP;
    }

    private function getResourceStub(string $model): string
    {
        $resource = $model . 'Resource';

        return <<<PHP
<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class $resource extends JsonResource
{
    public function toArray(\$request): array
    {
        \$data = parent::toArray(\$request);

        return array_merge(\$data, []);
    }
}
PHP;
    }

    private function getBaseRequestStub(string $model): string
    {
        $baseModelRequest = 'Base' . $model . 'Request';
        $modelClass = "App\\Models\\$model";

        try {
            $instance = new $modelClass();
            $fields = method_exists($instance, 'getFillable') ? $instance->getFillable() : [];
            $casts = method_exists($instance, 'getCasts') ? $instance->getCasts() : [];

            // Generate PHPDoc with field properties
            $fieldsComment = "/**\n";
            $fieldsComment .= " * Base request for $model model\n";
            foreach ($fields as $field) {
                $type = $casts[$field] ?? 'mixed';
                $fieldsComment .= " * @property $type \$$field\n";
            }
            $fieldsComment .= " */";

            // Generate rules array
            $rulesArray = [];
            foreach ($fields as $field) {
                $type = $casts[$field] ?? 'string';
                $rule = ['nullable'];

                $rule[] = match ($type) {
                    'int', 'integer' => 'integer',
                    'double', 'float' => 'numeric',
                    'boolean', 'bool' => 'boolean',
                    'date', 'datetime', 'timestamp' => 'date',
                    'array' => 'array',
                    'json' => 'json',
                    default => 'string',
                };

                $rulesArray[] = "'$field' => ['" . implode("', '", $rule) . "'],";
            }

            $rulesStr = empty($rulesArray) ?
                "            // Define your validation rules here" :
                "            " . implode("\n            ", $rulesArray);

        } catch (Exception) {
            $fieldsComment = "/**\n * Base request for $model model\n */";
            $rulesStr = "            // Define your validation rules here";
        }

        return <<<PHP
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

$fieldsComment
class $baseModelRequest extends FormRequest
{

    final public function rules(): array
    {
        return [
$rulesStr
        ];
    }
}
PHP;
    }


}
