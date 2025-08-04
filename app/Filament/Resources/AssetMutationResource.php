<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetMutationResource\Pages;
use App\Filament\Resources\AssetMutationResource\RelationManagers;
use App\Models\AssetMutation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssetMutationResource extends Resource
{
    protected static ?string $model = AssetMutation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('asset_id')
            ->relationship('asset', 'name')
            ->label('Aset')
            ->required()
            ->reactive()
            ->afterStateUpdated(function ($state, Set $set) {
                 $asset = \App\Models\Asset::find($state);
                if ($asset) {
                    $set('dari', $asset->lokasi);
                }
            }),

        Forms\Components\Select::make('from_user_id')
            ->relationship('fromUser', 'name')
            ->label('Dari Pengguna')
            ->searchable(),

        Forms\Components\Select::make('to_user_id')
            ->relationship('toUser', 'name')
            ->label('Ke Pengguna')
            ->searchable()
            ->required(),

        Forms\Components\TextInput::make('dari')
            ->label('Dari Lokasi')
            ->required(),
            // ->disabled(),

        Forms\Components\TextInput::make('ke')
            ->label('Ke Lokasi'),

        Forms\Components\DatePicker::make('mutation_date')
            ->label('Tanggal Mutasi')
            ->default(now())
            ->required(),

        Forms\Components\Textarea::make('notes')
            ->label('Keterangan')
            ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asset.name')->label('Aset'),
                Tables\Columns\TextColumn::make('fromUser.name')->label('Dari'),
                Tables\Columns\TextColumn::make('toUser.name')->label('Ke'),
                Tables\Columns\TextColumn::make('dari')->label('Dari Lokasi'),
                Tables\Columns\TextColumn::make('ke')->label('Ke Lokasi'),
                Tables\Columns\TextColumn::make('tanggal')->date()->label('Tanggal Mutasi'),
                Tables\Columns\TextColumn::make('notes')->label('Keterangan')->limit(20),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssetMutations::route('/'),
            'create' => Pages\CreateAssetMutation::route('/create'),
            'edit' => Pages\EditAssetMutation::route('/{record}/edit'),
        ];
    }
}
