<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    
    protected static ?string $navigationGroup = 'Study Portal';
    
    protected static ?string $navigationLabel = 'Kurslar';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Kurs Bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
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
                            ->label('Kısa Açıklama')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        Forms\Components\RichEditor::make('long_description')
                            ->label('Detaylı Açıklama')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Medya & Ayarlar')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->directory('courses/thumbnails'),
                        
                        Forms\Components\Select::make('difficulty')
                            ->label('Zorluk')
                            ->options([
                                'beginner' => 'Başlangıç',
                                'intermediate' => 'Orta',
                                'advanced' => 'İleri',
                            ])
                            ->default('beginner')
                            ->required(),
                        
                        Forms\Components\TextInput::make('estimated_hours')
                            ->label('Tahmini Süre (Saat)')
                            ->numeric()
                            ->default(0),
                        
                        Forms\Components\TextInput::make('order')
                            ->label('Sıra')
                            ->numeric()
                            ->default(0),
                    ])->columns(4),

                Forms\Components\Section::make('Yayın Ayarları')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Yayında')
                            ->default(false),
                        
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Öne Çıkan')
                            ->default(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Görsel')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('difficulty')
                    ->label('Zorluk')
                    ->badge()
                    ->colors([
                        'success' => 'beginner',
                        'warning' => 'intermediate',
                        'danger' => 'advanced',
                    ]),
                
                Tables\Columns\TextColumn::make('modules_count')
                    ->label('Modül')
                    ->counts('modules'),
                
                Tables\Columns\TextColumn::make('estimated_hours')
                    ->label('Süre')
                    ->suffix(' saat'),
                
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Yayında')
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Öne Çıkan')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('view_count')
                    ->label('Görüntülenme')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('difficulty')
                    ->label('Zorluk')
                    ->options([
                        'beginner' => 'Başlangıç',
                        'intermediate' => 'Orta',
                        'advanced' => 'İleri',
                    ]),
                
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Yayında'),
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
            ->defaultSort('order', 'asc')
            ->reorderable('order');
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
