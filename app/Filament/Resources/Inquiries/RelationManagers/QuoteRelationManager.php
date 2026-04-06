<?php

namespace App\Filament\Resources\Inquiries\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;

class QuoteRelationManager extends RelationManager
{
    protected static string $relationship = 'quote';

    protected static ?string $title = 'Quote';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Supplier Cost (Internal — not visible to customer)')
                ->description('This section is never shown to the customer.')
                ->collapsible()
                ->components([
                    TextInput::make('supplier_name')
                        ->label('Supplier Name')
                        ->placeholder('e.g. Nippon Steel via agent'),
                    TextInput::make('cost_per_mt')
                        ->label('Cost per MT (RM)')
                        ->numeric()->prefix('RM')
                        ->live()
                        ->afterStateUpdated(fn ($state, $set, $get) => self::recalcCost($set, $get)),
                    TextInput::make('est_total_mt')
                        ->label('Est. Total MT')
                        ->numeric()->suffix('MT')
                        ->live()
                        ->afterStateUpdated(fn ($state, $set, $get) => self::recalcCost($set, $get)),
                    TextInput::make('freight_cost')
                        ->label('Freight / Handling (RM)')
                        ->numeric()->prefix('RM')->default(0)
                        ->live()
                        ->afterStateUpdated(fn ($state, $set, $get) => self::recalcCost($set, $get)),
                    TextInput::make('other_costs')
                        ->label('Other Costs (RM)')
                        ->numeric()->prefix('RM')->default(0)
                        ->live()
                        ->afterStateUpdated(fn ($state, $set, $get) => self::recalcCost($set, $get)),
                    TextInput::make('total_cost')
                        ->label('Total Cost (auto)')
                        ->numeric()->prefix('RM')
                        ->disabled()->dehydrated(),
                ])->columns(2),

            Section::make('Quote to Customer')
                ->components([
                    TextInput::make('selling_price_per_mt')
                        ->label('Selling Price per MT (RM)')
                        ->numeric()->prefix('RM')->required()
                        ->live()
                        ->afterStateUpdated(fn ($state, $set, $get) => self::recalcSelling($set, $get)),
                    TextInput::make('total_selling_price')
                        ->label('Total Selling Price (auto)')
                        ->numeric()->prefix('RM')
                        ->disabled()->dehydrated(),
                    TextInput::make('payment_terms')
                        ->label('Payment Terms')
                        ->placeholder('e.g. 50% deposit, balance before delivery')
                        ->required(),
                    TextInput::make('lead_time')
                        ->label('Lead Time')
                        ->placeholder('e.g. 4–6 weeks from PO')
                        ->required(),
                    DatePicker::make('valid_until')
                        ->label('Valid Until')->required(),
                    Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'sent'  => 'Sent to Customer',
                        ])
                        ->default('draft')->required(),
                    Textarea::make('remarks')
                        ->label('Remarks to Customer')
                        ->rows(3)->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('selling_price_per_mt')
                    ->label('Sell Price / MT')
                    ->formatStateUsing(fn ($state) => 'RM ' . number_format($state, 2)),
                TextColumn::make('total_selling_price')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => 'RM ' . number_format($state, 2)),
                TextColumn::make('payment_terms')->label('Payment'),
                TextColumn::make('valid_until')->label('Valid Until')->date(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft'    => 'gray',
                        'sent'     => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'expired'  => 'warning',
                        default    => 'gray',
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('send')
                    ->label('Send to Customer')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'draft')
                    ->requiresConfirmation()
                    ->modalHeading('Send quote to customer?')
                    ->modalDescription('This will mark the quote as Sent and the customer will see it in their portal.')
                    ->action(function ($record) {
                        $record->update(['status' => 'sent']);
                        $record->inquiry->update(['status' => 'quoted']);
                        Notification::make()
                            ->title('Quote sent to customer')
                            ->success()
                            ->send();
                    }),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Create Quote')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['inquiry_id'] = $this->getOwnerRecord()->id;
                        return $data;
                    }),
            ]);
    }

    private static function recalcCost($set, $get): void
    {
        $total = (floatval($get('cost_per_mt')) * floatval($get('est_total_mt')))
            + floatval($get('freight_cost'))
            + floatval($get('other_costs'));
        $set('total_cost', round($total, 2));
    }

    private static function recalcSelling($set, $get): void
    {
        $total = floatval($get('selling_price_per_mt')) * floatval($get('est_total_mt'));
        $set('total_selling_price', round($total, 2));
    }
}
