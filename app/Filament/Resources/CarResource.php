<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Машинууд';

    // ====== ФОРМ ======
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Машины мэдээлэл')
                    ->schema([
                        Forms\Components\TextInput::make('plate_number')
                            ->label('Улсын дугаар')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('brand')
                            ->label('Марк')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('model')
                            ->label('Загвар')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('year')
                            ->label('Гаралтын жил')
                            ->numeric()
                            ->required()
                            ->minValue(1900)
                            ->maxValue(now()->year + 1),

                        Forms\Components\Select::make('customer_id')
                            ->label('Үйлчлүүлэгч')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\FileUpload::make('image')
                            ->label('Машины зураг')
                            ->image()
                            ->directory('cars')
                            ->imageEditor()
                            ->maxSize(5120)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    // ====== ЖАГСААЛТ ======
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Зураг')
                    ->circular()
                    ->defaultImageUrl(asset('images/no-car.png')),

                Tables\Columns\TextColumn::make('plate_number')
                    ->label('Улсын дугаар')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('brand')
                    ->label('Марк')
                    ->searchable(),

                Tables\Columns\TextColumn::make('model')
                    ->label('Загвар'),

                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Үйлчлүүлэгч')
                    ->searchable(),

                Tables\Columns\TextColumn::make('year')
                    ->label('Жил'),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->label('Устгасан огноо')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(), // устгасан машинуудыг шүүх
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit'   => Pages\EditCar::route('/{record}/edit'),
        ];
    }

    // Laravel 8.1 дээр зөв ажилладаг болгохын тулд withoutTrashed()-г арилгаж, 
    // модель дотор global scope нэмсэн учраас энд юу ч хийх шаардлагагүй
}