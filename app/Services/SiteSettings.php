<?php
namespace App\Services;
use App\Models\Setting;
use Illuminate\Support\Collection;
class SiteSettings
{
    public function all(): Collection { return Setting::pluck('value','key'); }
    public function get(string $key, mixed $default=null): mixed { return $this->all()->get($key,$default); }
    public function put(array $values): void { foreach($values as $key=>$value) Setting::updateOrCreate(['key'=>$key],['value'=>$value ?? '']); }
}
