<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Throwable;

// Configurações gerais do site (contatos, redes sociais, link da loja,
// números institucionais), editadas em "Configurações do site" no painel.
// Registro único (id 1) com os dados em JSON.
class SiteSetting extends Model
{
    protected $fillable = ['data'];

    protected $casts = ['data' => 'array'];

    public const DEFAULTS = [
        'company_name' => 'Tinsei',
        'legal_name' => 'Tinsei Comércio Importação e Distribuição Ltda',
        'cnpj' => '13.839.772/0001-63',
        'tagline' => 'Soluções sustentáveis em equipamentos de impressão digital',
        'store_url' => 'https://loja.tinsei.com.br/',
        'store_reseller_url' => 'https://loja.tinsei.com.br/revendedor',
        'phone' => '(31) 3396-1435',
        'whatsapp' => '553133961435',
        'whatsapp_sales' => '553184366212',
        'email' => 'atendimento@tinsei.com.br',
        'careers_email' => 'atendimento@tinsei.com.br',
        'contact_notify_email' => 'atendimento@tinsei.com.br',
        'address' => "Anel Rodoviário Celso Mello Azevedo, 1206\nOlhos D'Água, Belo Horizonte - MG\nCEP 30390-085",
        'maps_query' => "Tinsei, Anel Rodoviário Celso Mello Azevedo, 1206, Olhos D'Água, Belo Horizonte - MG",
        'business_hours' => '',
        'instagram_url' => 'https://www.instagram.com/tinseioficial/',
        'youtube_url' => 'https://www.youtube.com/channel/UC7UPYJhEpA0MCQA5k3Ij2dg',
        'linkedin_url' => 'https://www.linkedin.com/company/tinsei/',
        'facebook_url' => 'https://www.facebook.com/tinseioficial/',
        'founded_year' => '2011',
        'active_clients_override' => '3230',
        'portfolio_items' => '1.800+',
        'ewaste_kg' => '1.800.000',
        'institutional_video_url' => 'https://www.youtube.com/watch?v=YFCMNfKTSME',
        'google_analytics_id' => '',
    ];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], ['data' => self::DEFAULTS]);
    }

    public static function all_values(): array
    {
        try {
            if (! Schema::hasTable('site_settings')) {
                return self::DEFAULTS;
            }

            return Cache::rememberForever('site_settings', fn () => array_merge(self::DEFAULTS, array_filter(
                (array) (static::find(1)?->data ?? []),
                fn ($value) => $value !== null
            )));
        } catch (Throwable) {
            return self::DEFAULTS;
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return Arr::get(self::all_values(), $key, $default);
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site_settings'));
    }
}
