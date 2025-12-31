<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Models\Game;
use App\Services\GameUploadService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';
    
    protected static ?string $navigationLabel = 'Oyunlar';
    
    protected static ?string $modelLabel = 'Oyun';
    
    protected static ?string $pluralModelLabel = 'Oyunlar';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Oyun Bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Oyun Adı')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $state, Forms\Set $set) => 
                                $set('slug', Str::slug($state))),
                        
                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        
                        Forms\Components\Textarea::make('description')
                            ->label('Açıklama')
                            ->required()
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('icon')
                            ->label('İkon (Emoji)')
                            ->maxLength(10)
                            ->placeholder('🎮'),
                    ])->columns(2),

                Forms\Components\Section::make('Oyun Dosyaları')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->directory('game-thumbnails')
                            ->maxSize(1024),
                        
                        Forms\Components\FileUpload::make('zip_upload')
                            ->label('HTML5 Oyun ZIP')
                            ->disk('local')
                            ->directory('temp-game-uploads')
                            ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                            ->maxSize(51200) // 50MB
                            ->helperText('ZIP dosyası içinde index.html olmalı')
                            ->dehydrated(false), // Bu alan veritabanına kaydedilmez
                    ])->columns(2),

                Forms\Components\Section::make('Ayarlar')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                        
                        Forms\Components\TextInput::make('order')
                            ->label('Sıra')
                            ->numeric()
                            ->default(0),
                        
                        Forms\Components\Placeholder::make('play_url')
                            ->label('Oynat URL')
                            ->content(fn (?Game $record): string => 
                                $record && $record->extracted_path 
                                    ? 'https://games.alienes.me/play/' . $record->slug 
                                    : 'ZIP yüklendikten sonra görünecek'
                            )
                            ->visibleOn('edit'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Görsel')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('icon')
                    ->label('İkon'),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Oyun Adı')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('extracted_path')
                    ->label('ZIP Durumu')
                    ->formatStateUsing(fn ($state) => $state ? '✓ Yüklendi' : '✗ Yok')
                    ->color(fn ($state) => $state ? 'success' : 'gray'),
                
                Tables\Columns\TextColumn::make('order')
                    ->label('Sıra')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktif'),
            ])
            ->actions([
                Tables\Actions\Action::make('play')
                    ->label('Oyna')
                    ->icon('heroicon-o-play')
                    ->url(fn (Game $record) => 
                        $record->extracted_path 
                            ? 'https://games.alienes.me/play/' . $record->slug 
                            : null
                    )
                    ->openUrlInNewTab()
                    ->visible(fn (Game $record) => $record->extracted_path),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
