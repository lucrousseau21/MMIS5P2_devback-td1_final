<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\BelongsToSelect;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('customer_id')
                    ->required()
                    ->label('Customer ID'),
                TextInput::make('total')
                    ->required()
                    ->label('Total')
                    ->disabled(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->label('Status'),
                Repeater::make('items')
                    ->relationship('items')
                    ->schema([
                        BelongsToSelect::make('product_id')
                            ->relationship('product', 'name')
                            ->label('Product')
                            ->searchable()
                            ->columnSpan(12)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $product = Product::find($state);
                                $quantity = $get('quantity');
                                $set('price', $product ? $product->price * $quantity : 0);

                                $items = $get('items');
                                $total = collect($items)->sum(fn ($item) => $item['price']);
                                $set('total', $total);
                            }),
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->columnSpan(6)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $product = Product::find($get('product_id'));
                                $set('price', $product ? $product->price * $state : 0);

                                $items = $get('items');
                                $total = collect($items)->sum(fn ($item) => $item['price']);
                                $set('total', $total);
                            }),
                        TextInput::make('price')
                            ->label('Price')
                            ->disabled()
                            ->columnSpan(6),
                    ])
                    ->columns(12)
                    ->columnSpan('full')
                    ->label('Order Items')
                    ->afterStateUpdated(function (callable $set, callable $get) {
                        $items = $get('items');
                        $total = collect($items)->sum(fn ($item) => $item['price']);
                        $set('total', $total);
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('customer_id')->label('Customer ID')->sortable(),
                TextColumn::make('total')->label('Total')->sortable(),
                TextColumn::make('status')->label('Status')->sortable(),
                TextColumn::make('created_at')->label('Created At')->sortable(),
                TextColumn::make('updated_at')->label('Updated At')->sortable(),
                TextColumn::make('items_count')
                    ->label('Items Count')
                    ->counts('items')
                    ->sortable(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}