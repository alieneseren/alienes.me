<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket-square';
    
    protected static ?string $navigationLabel = 'Projeler';
    
    protected static ?string $modelLabel = 'Proje';
    
    protected static ?string $pluralModelLabel = 'Projeler';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Proje Bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description')
                            ->label('Açıklama')
                            ->required()
                            ->columnSpanFull(),
                        
                        Forms\Components\TagsInput::make('technologies')
                            ->label('Teknolojiler')
                            ->placeholder('Teknoloji ekle...')
                            ->helperText('Enter tuşu ile ekleyin'),
                    ])->columns(2),

                Forms\Components\Section::make('Görseller & Linkler')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Proje Görseli')
                            ->image()
                            ->directory('project-images')
                            ->maxSize(2048),
                        
                        Forms\Components\TextInput::make('demo_url')
                            ->label('Demo URL')
                            ->url()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('github_url')
                            ->label('GitHub URL')
                            ->url()
                            ->maxLength(255),
                    ])->columns(3),

                Forms\Components\Section::make('Ayarlar')
                    ->schema([
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Öne Çıkan')
                            ->default(false),
                        
                        Forms\Components\TextInput::make('order')
                            ->label('Sıra')
                            ->numeric()
                            ->default(0),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Görsel')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('technologies')
                    ->label('Teknolojiler')
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Öne Çıkan')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('order')
                    ->label('Sıra')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Öne Çıkan'),
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
            ->defaultSort('order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
