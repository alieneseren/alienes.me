<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AchievementResource\Pages;
use App\Models\Achievement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    
    protected static ?string $navigationGroup = 'Gamification';
    
    protected static ?string $navigationLabel = 'Başarımlar';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Başarım Bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('İsim')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description')
                            ->label('Açıklama')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Görsel & Puan')
                    ->schema([
                        Forms\Components\TextInput::make('icon')
                            ->label('İkon')
                            ->placeholder('heroicon-o-star veya emoji')
                            ->maxLength(100),
                        
                        Forms\Components\TextInput::make('points')
                            ->label('Puan')
                            ->numeric()
                            ->required()
                            ->default(10)
                            ->minValue(0),
                        
                        Forms\Components\Select::make('type')
                            ->label('Tip')
                            ->options([
                                'skill' => 'Yetenek',
                                'milestone' => 'Kilometre Taşı',
                                'challenge' => 'Meydan Okuma',
                            ])
                            ->required()
                            ->default('skill'),
                        
                        Forms\Components\Select::make('rarity')
                            ->label('Nadirlik')
                            ->options([
                                'common' => 'Yaygın',
                                'uncommon' => 'Nadir',
                                'rare' => 'Çok Nadir',
                                'epic' => 'Epik',
                                'legendary' => 'Efsanevi',
                            ])
                            ->required()
                            ->default('common'),
                    ])->columns(4),

                Forms\Components\Section::make('İlişkiler & Gereksinimler')
                    ->schema([
                        Forms\Components\Select::make('game_id')
                            ->label('Oyun')
                            ->relationship('game', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        
                        Forms\Components\KeyValue::make('requirements')
                            ->label('Gereksinimler')
                            ->keyLabel('Koşul')
                            ->valueLabel('Değer')
                            ->addButtonLabel('Gereksinim Ekle')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('icon')
                    ->label('İkon')
                    ->formatStateUsing(fn ($state) => $state ?: '🏆'),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('İsim')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('type')
                    ->label('Tip')
                    ->badge()
                    ->colors([
                        'primary' => 'skill',
                        'success' => 'milestone',
                        'warning' => 'challenge',
                    ]),
                
                Tables\Columns\TextColumn::make('rarity')
                    ->label('Nadirlik')
                    ->badge()
                    ->colors([
                        'gray' => 'common',
                        'success' => 'uncommon',
                        'primary' => 'rare',
                        'warning' => 'epic',
                        'danger' => 'legendary',
                    ]),
                
                Tables\Columns\TextColumn::make('points')
                    ->label('Puan')
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('game.name')
                    ->label('Oyun')
                    ->searchable()
                    ->default('-'),
                
                Tables\Columns\TextColumn::make('unlocked_count')
                    ->label('Kazanan')
                    ->numeric(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tip')
                    ->options([
                        'skill' => 'Yetenek',
                        'milestone' => 'Kilometre Taşı',
                        'challenge' => 'Meydan Okuma',
                    ]),
                
                Tables\Filters\SelectFilter::make('rarity')
                    ->label('Nadirlik')
                    ->options([
                        'common' => 'Yaygın',
                        'uncommon' => 'Nadir',
                        'rare' => 'Çok Nadir',
                        'epic' => 'Epik',
                        'legendary' => 'Efsanevi',
                    ]),
                
                Tables\Filters\SelectFilter::make('game_id')
                    ->label('Oyun')
                    ->relationship('game', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('points', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAchievements::route('/'),
            'create' => Pages\CreateAchievement::route('/create'),
            'edit' => Pages\EditAchievement::route('/{record}/edit'),
        ];
    }
}
