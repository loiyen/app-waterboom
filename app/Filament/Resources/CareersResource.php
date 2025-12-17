<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Careers;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CareersResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CareersResource\RelationManagers;

class CareersResource extends Resource
{
    protected static ?string $model = Careers::class;
    protected static ?string $navigationGroup = 'Manajemen Lowongan';
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    public static function getPluralLabel(): string
    {
        return 'Careers';
    }
    public static function getLabel(): string
    {
        return 'Careers';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('position')
                    ->label('Posisi')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->label('Slug')
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(255),
                TextInput::make('department')
                    ->label('Departemen / Devisi')
                    ->required(),
                Select::make('job_type')
                    ->label('Status Perkerjaan')
                    ->options([
                        'full_time'             => 'Full_time',
                        'part_time'             => 'Part_time',
                        'internship'            => 'Internship',
                    ]),
                RichEditor::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'subscript',
                        'superscript',
                        'heading',
                        'alignLeft',
                        'alignCenter',
                        'alignRight',
                        'alignJustify',
                        'orderedList',
                        'bulletList',
                        'blockquote',
                        'codeBlock',
                        'horizontalRule',
                        'link',
                        'clearFormatting',
                        'undo',
                        'redo',
                    ])
                    ->columnSpanFull()
                    ->required(),
                RichEditor::make('requirements')
                    ->label('Kualifikasi / Persyaratan')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'subscript',
                        'superscript',
                        'heading',
                        'alignLeft',
                        'alignCenter',
                        'alignRight',
                        'alignJustify',
                        'orderedList',
                        'bulletList',
                        'blockquote',
                        'codeBlock',
                        'horizontalRule',
                        'link',
                        'clearFormatting',
                        'undo',
                        'redo',
                    ])
                    ->columnSpanFull()
                    ->required(),

                FileUpload::make('image')
                    ->label('Upload Foto')
                    ->image()
                    ->directory('uploads')
                    ->visibility('public')
                    ->maxSize(5048)
                    ->required()
                    ->columnSpanFull()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg']),
                TextInput::make('benefits')
                    ->label('Benefit')
                    ->required(),
                DatePicker::make('deadline')
                    ->label('Batas Pendaftaran')
                    ->native(false)
                    ->required()
                    ->displayFormat('d/m/Y')
                    ->format('Y-m-d'),
                Toggle::make('is_active')
                    ->label('Aktifkan postingan?')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-o-check')
                    ->offIcon('heroicon-o-x-mark')
                    ->default(true)
                    ->afterStateHydrated(fn(callable $set, $state) => $set('is_active', (bool) $state))
                    ->dehydrateStateUsing(fn($state) => $state ? 1 : 0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('TANGGAL')
                    ->formatStateUsing(
                        fn($state) =>
                        Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y H:i')
                    )
                    ->sortable()
                    ->wrap(),
                TextColumn::make('image')
                    ->label('FOTO')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Preview' : '-')
                    ->icon(fn(bool $state): string => $state ? 'heroicon-o-eye' : 'heroicon-o-eye')
                    ->url(fn($record) => $record->thumbail ? asset('storage/' . $record->image) : null)
                    ->openUrlInNewTab(),
                TextColumn::make('position')
                    ->label('POSISI'),
                TextColumn::make('department')
                    ->label('DEPARTEMEN'),
                TextColumn::make('description')
                    ->label('DESKRIPSI')
                    ->limit(30)
                    ->tooltip(fn($state) => $state)
                    ->wrap(),
                TextColumn::make('requirements')
                    ->label('PERSYARATAN')
                    ->limit(30)
                    ->tooltip(fn($state) => $state)
                    ->wrap(),
                TextColumn::make('job_type')
                    ->label('TIPE')
                    ->badge(),
                TextColumn::make('deadline')
                    ->label('BATAS')
                    ->formatStateUsing(
                        fn($state) =>
                        Carbon::parse($state)
                            ->locale('id')
                            ->translatedFormat('d F Y')
                    ),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCareers::route('/'),
            'create' => Pages\CreateCareers::route('/create'),
            'edit' => Pages\EditCareers::route('/{record}/edit'),
        ];
    }
}
