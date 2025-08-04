<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetResource\Pages;
use App\Models\Asset;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
// use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('serial_number'),

                Forms\Components\Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'Laptop' => 'Laptop',
                        'Printer' => 'Printer',
                        'Monitor' => 'Monitor',
                        'Networking' => 'Networking',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Tidak Aktif' => 'Tidak Aktif',
                        'Rusak' => 'Rusak',
                    ])
                    ->required(),

                Forms\Components\Select::make('kondisi')
                    ->options([
                        'Baik' => 'Baik',
                        'Cukup' => 'Cukup',
                        'Rusak' => 'Rusak',
                    ])
                    ->required(),

                Forms\Components\Select::make('lokasi')
                    ->options([
                        'Kantor Pusat' => 'Kantor Pusat',
                        'Gudang A' => 'Gudang A',
                        'Gudang B' => 'Gudang B',
                        'Remote' => 'Remote',
                    ])
                    ->searchable()
                    ->required(),

                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('assets/images'),

                Forms\Components\Select::make('assigned_to')
                    ->relationship('assignedUser', 'name')
                    ->label('Assigned To')
                    ->searchable()
                    ->preload(),

                Forms\Components\DatePicker::make('assigned_at')
                    ->label('Tanggal Assigned')
                    ->default(now())
                    ->required(),
                    // ->visible(fn ($get) => $get('assigned_to') !== null),

                Forms\Components\FileUpload::make('invoice_file')
                    ->label('Invoice Pembelian')
                    ->disk('public')
                    ->directory('invoices')
                    ->acceptedFileTypes(['application/pdf', 'image/*', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                    ->enableDownload()
                    ->previewable()
                    ->columnSpanFull(6),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('kategori')->label('Category'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('kondisi'),
                Tables\Columns\TextColumn::make('lokasi'),  
                Tables\Columns\ImageColumn::make('image')->label('Gambar')->disk('public')->size(60),
                Tables\Columns\ImageColumn::make('qr_code_path')->label('QR Code')->disk('public')->size(60)->visible(fn () => auth()->user()->role === 'admin'), // ⬅️ hanya admin bisa lihat
                Tables\Columns\TextColumn::make('assignedUser.name')->label('Assigned To'),
                Tables\Columns\TextColumn::make('assigned_at')->label('Tanggal Assigned')->dateTime('d-m-Y H:i:s'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make('view'),
                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()->role === 'admin'),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => auth()->user()->role === 'admin'),
                Tables\Actions\Action::make('download_qr')
                    ->label('Download QR')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => route('assets.downloadQr', $record))
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => auth()->user()->role === 'admin' && !empty($record->qr_code_path))

            ])
            ->bulkActions([
                // ExportBulkAction::make()
                //     ->label('Export ke Excel')
                //     ->color('success')
                //     ->icon('heroicon-o-arrow-down-tray')
                //     ->exporter(\pxlrbt\FilamentExcel\Exports\ExcelExporter::class),
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => auth()->user()->role === 'admin'),
                
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // if (Auth::check() && Auth::user()->role !== 'admin') {
        //     $query->where('assigned_to', Auth::id());
        // }

        if (auth()->user()->role === 'user') {
            $query->where('assigned_to',auth()->id());
        }

        return $query;
    }


    public static function canCreate(): bool
    {
        return auth()->user()->role === 'admin';
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'view' => Pages\ViewAsset::route('/{record}'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }
}
