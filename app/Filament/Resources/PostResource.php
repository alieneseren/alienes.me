<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Blog Yazıları';
    
    protected static ?string $modelLabel = 'Yazı';
    
    protected static ?string $pluralModelLabel = 'Yazılar';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Yazı İçeriği')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
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
                        
                        Forms\Components\RichEditor::make('content')
                            ->label('İçerik')
                            ->required()
                            ->columnSpanFull(),
                        
                        Forms\Components\Textarea::make('excerpt')
                            ->label('Özet')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Görsel & Etiketler')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->label('Kapak Görseli')
                            ->image()
                            ->directory('blog-images')
                            ->maxSize(2048),
                        
                        Forms\Components\Select::make('tags')
                            ->label('Etiketler')
                            ->multiple()
                            ->relationship('tags', 'name')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(50),
                            ])
                            ->preload(),
                    ])->columns(2),

                Forms\Components\Section::make('Yayın Ayarları')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Yayınla')
                            ->default(false),
                        
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Yayın Tarihi')
                            ->default(now()),
                        
                        Forms\Components\TextInput::make('meta_description')
                            ->label('SEO Açıklaması')
                            ->maxLength(160)
                            ->helperText('Arama motorları için açıklama (max 160 karakter)'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Görsel')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('tags.name')
                    ->label('Etiketler')
                    ->badge()
                    ->color('primary'),
                
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Yayında')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Yayın Tarihi')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Yayın Durumu'),
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
