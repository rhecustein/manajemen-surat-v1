<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'subject',
        'body_html',
        'body_text',
        'variables',
        'is_active',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user who created this template
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get email logs using this template
     */
    public function emailLogs()
    {
        return $this->hasMany(EmailLog::class, 'template_id');
    }

    /**
     * Render template with variables
     */
    public function render(array $data = []): array
    {
        $subject = $this->subject;
        $bodyHtml = $this->body_html;
        $bodyText = $this->body_text;

        // Replace variables in template
        foreach ($data as $key => $value) {
            $placeholder = '{{' . $key . '}}';
            $subject = str_replace($placeholder, $value, $subject);
            $bodyHtml = str_replace($placeholder, $value, $bodyHtml);
            $bodyText = str_replace($placeholder, $value, $bodyText);
        }

        return [
            'subject' => $subject,
            'body_html' => $bodyHtml,
            'body_text' => $bodyText,
        ];
    }

    /**
     * Get available variables
     */
    public function getAvailableVariablesAttribute(): array
    {
        return $this->variables ?? [];
    }

    /**
     * Extract variables from template content
     */
    public function extractVariables(): array
    {
        $content = $this->subject . ' ' . $this->body_html . ' ' . $this->body_text;
        preg_match_all('/\{\{(\w+)\}\}/', $content, $matches);
        return array_unique($matches[1]);
    }

    /**
     * Scope active templates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by name
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }

    /**
     * Search templates
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('subject', 'like', "%{$search}%");
        });
    }

    /**
     * Get template usage count
     */
    public function getUsageCountAttribute(): int
    {
        return $this->emailLogs()->count();
    }

    /**
     * Clone template
     */
    public function duplicate($newName = null): self
    {
        $newTemplate = $this->replicate();
        $newTemplate->name = $newName ?? $this->name . ' (Copy)';
        $newTemplate->created_by = auth()->id();
        $newTemplate->save();

        return $newTemplate;
    }

    /**
     * Default templates
     */
    public static function getDefaultTemplates(): array
    {
        return [
            'surat_masuk_notification' => [
                'name' => 'Notifikasi Surat Masuk',
                'subject' => 'Surat Masuk Baru: {{perihal}}',
                'body_html' => '<h2>Surat Masuk Baru</h2><p>Telah diterima surat masuk baru dengan detail:</p><ul><li>Nomor: {{nomor_surat}}</li><li>Pengirim: {{pengirim}}</li><li>Perihal: {{perihal}}</li><li>Tanggal: {{tanggal_surat}}</li></ul><p>Silakan login ke sistem untuk melihat detail lengkap.</p>',
                'body_text' => 'Surat Masuk Baru\n\nNomor: {{nomor_surat}}\nPengirim: {{pengirim}}\nPerihal: {{perihal}}\nTanggal: {{tanggal_surat}}\n\nSilakan login ke sistem untuk melihat detail lengkap.',
                'variables' => ['nomor_surat', 'pengirim', 'perihal', 'tanggal_surat'],
            ],
            'disposisi_notification' => [
                'name' => 'Notifikasi Disposisi',
                'subject' => 'Disposisi Baru: {{perihal}}',
                'body_html' => '<h2>Disposisi Baru</h2><p>Anda mendapat disposisi baru dari {{dari_user}}:</p><ul><li>Surat: {{nomor_surat}}</li><li>Perihal: {{perihal}}</li><li>Instruksi: {{instruksi}}</li><li>Deadline: {{due_date}}</li></ul><p>Silakan login ke sistem untuk memberikan tindak lanjut.</p>',
                'body_text' => 'Disposisi Baru\n\nDari: {{dari_user}}\nSurat: {{nomor_surat}}\nPerihal: {{perihal}}\nInstruksi: {{instruksi}}\nDeadline: {{due_date}}\n\nSilakan login ke sistem untuk memberikan tindak lanjut.',
                'variables' => ['dari_user', 'nomor_surat', 'perihal', 'instruksi', 'due_date'],
            ],
            'surat_keluar_approval' => [
                'name' => 'Persetujuan Surat Keluar',
                'subject' => 'Persetujuan Surat Keluar: {{perihal}}',
                'body_html' => '<h2>Persetujuan Surat Keluar</h2><p>Surat keluar berikut memerlukan persetujuan Anda:</p><ul><li>Nomor: {{nomor_surat}}</li><li>Tujuan: {{tujuan}}</li><li>Perihal: {{perihal}}</li><li>Dibuat oleh: {{created_by}}</li></ul><p>Silakan login ke sistem untuk memberikan persetujuan.</p>',
                'body_text' => 'Persetujuan Surat Keluar\n\nNomor: {{nomor_surat}}\nTujuan: {{tujuan}}\nPerihal: {{perihal}}\nDibuat oleh: {{created_by}}\n\nSilakan login ke sistem untuk memberikan persetujuan.',
                'variables' => ['nomor_surat', 'tujuan', 'perihal', 'created_by'],
            ],
        ];
    }

    /**
     * Seed default templates
     */
    public static function seedDefaults($userId = null): void
    {
        $userId = $userId ?? User::where('role', 'admin')->first()?->id ?? 1;

        foreach (self::getDefaultTemplates() as $key => $template) {
            self::updateOrCreate(
                ['name' => $template['name']],
                array_merge($template, ['created_by' => $userId])
            );
        }
    }
}