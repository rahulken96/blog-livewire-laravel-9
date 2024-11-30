<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use App\Models\Post;
use App\Models\User;
use Filament\Tables;
use App\Models\Category;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        $dataUser = User::orderBy('name', 'asc')->get()->pluck('name', 'id');
        $dataCategory = Category::orderBy('title', 'asc')->get()->pluck('title', 'id');

        return $form
            ->schema([
                Section::make('Konten Utama')->schema([
                    TextInput::make('title')
                        ->required()
                        ->minLength(1)
                        ->maxLength(150)
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $set('slug', Str::slug($state));
                        })
                        ->reactive(),
                    TextInput::make('slug')->required()->minLength(1)->maxLength(150)->unique(ignoreRecord: true),
                    RichEditor::make('content')->fileAttachmentsDirectory('posts')->columnSpanFull(),
                ])->columns(2),
                Section::make('Meta Data')->schema([
                    FileUpload::make('image')->image()->directory('posts/thumbnails'),
                    DateTimePicker::make('published_at')->nullable(),
                    Checkbox::make('is_publish')->label('Publikasikan ?'),

                    /* Cara Mencari Data Ke-1 */
                    // Select::make('user_id')->label('Penulis')->relationship('penulis', 'name')->options($dataUser)->searchable()->required(),

                    /* Cara Mencari Data Ke-2 */
                    Select::make('user_id')->label('Penulis')->relationship('penulis', 'name')->searchable()->required()->preload(),

                    /* Cara Mencari Data Ke-3 (Custom Search) */
                    // Select::make('user_id')
                    // ->relationship('penulis', 'name')
                    // ->getSearchResultsUsing(fn (string $search) => User::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id'))
                    // ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->name)
                    // ->searchable()
                    // ->required(),

                    // Select::make('Kategori')->relationship('categories', 'title')->multiple()->options($dataCategory)->searchable(),
                    Select::make('Kategori')->relationship('categories', 'title')->multiple()->searchable()->preload(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('id')->label('No.')->sortable(),
                TextColumn::make('title')->label('Judul')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()->searchable(),
                TextColumn::make('penulis.name')->sortable()->searchable(),
                TextColumn::make('published_at')->label('Terbit Tanggal')->dateTime('d M Y H:i')->sortable()->searchable(),
                CheckboxColumn::make('is_publish')->label('Terbit'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
