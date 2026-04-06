<?php

namespace App\Filament\Resources\Quotes\Schemas;

use App\Models\Inquiry;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class QuoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Inquiry')
                    ->components([
                        Select::make('inquiry_id')
                            ->label('Linked Inquiry')
                            ->relationship('inquiry', 'grade')
                            ->getOptionLabelFromRecordUsing(fn (Inquiry $record) =>
                                'INQ-' . str_pad($record->id, 3, '0', STR_PAD_LEFT) .
                                ' — ' . $record->user?->name .
                                ' (' . $record->grade . ' · ' . $record->width_mm . 'mm · ' . $record->thickness_mm . 'mm · ' . $record->quantity_coils . ' coils)'
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                Section::make('Supplier Cost (Internal — not visible to customer)')
                    ->description('This section is never shown to the customer.')
                    ->collapsible()
                    ->components([
                        TextInput::make('supplier_name')
                            ->label('Supplier Name')
                            ->placeholder('e.g. Nippon Steel via agent'),
                        TextInput::make('cost_per_mt')
                            ->label('Cost per MT (RM)')
                            ->numeric()
                            ->prefix('RM')
                            ->live()
                            ->afterStateUpdated(fn ($state, $set, $get) =>
                                self::recalcTotalCost($state, $set, $get)
                            ),
                        TextInput::make('est_total_mt')
                            ->label('Est. Total MT')
                            ->numeric()
                            ->suffix('MT')
                            ->live()
                            ->afterStateUpdated(fn ($state, $set, $get) =>
                                self::recalcTotalCost($get('cost_per_mt'), $set, $get)
                            ),
                        TextInput::make('freight_cost')
                            ->label('Freight / Handling (RM)')
                            ->numeric()
                            ->prefix('RM')
                            ->default(0)
                            ->live()
                            ->afterStateUpdated(fn ($state, $set, $get) =>
                                self::recalcTotalCost($get('cost_per_mt'), $set, $get)
                            ),
                        TextInput::make('other_costs')
                            ->label('Other Costs (RM)')
                            ->numeric()
                            ->prefix('RM')
                            ->default(0)
                            ->live()
                            ->afterStateUpdated(fn ($state, $set, $get) =>
                                self::recalcTotalCost($get('cost_per_mt'), $set, $get)
                            ),
                        TextInput::make('total_cost')
                            ->label('Total Cost (auto-calculated)')
                            ->numeric()
                            ->prefix('RM')
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2),

                Section::make('Quote to Customer')
                    ->components([
                        TextInput::make('selling_price_per_mt')
                            ->label('Selling Price per MT (RM)')
                            ->numeric()
                            ->prefix('RM')
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, $set, $get) =>
                                self::recalcSellingTotal($state, $set, $get)
                            ),
                        TextInput::make('total_selling_price')
                            ->label('Total Selling Price (auto-calculated)')
                            ->numeric()
                            ->prefix('RM')
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('payment_terms')
                            ->label('Payment Terms')
                            ->placeholder('e.g. 50% deposit, balance before delivery')
                            ->required(),
                        TextInput::make('lead_time')
                            ->label('Lead Time')
                            ->placeholder('e.g. 4–6 weeks from PO')
                            ->required(),
                        DatePicker::make('valid_until')
                            ->label('Quote Valid Until')
                            ->required(),
                        Select::make('status')
                            ->options([
                                'draft'    => 'Draft',
                                'sent'     => 'Sent',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                                'expired'  => 'Expired',
                            ])
                            ->default('draft')
                            ->required(),
                        Textarea::make('remarks')
                            ->label('Remarks to Customer')
                            ->placeholder('e.g. Mill certificate (3.1B) included. Origin: Japan.')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    private static function recalcTotalCost($costPerMt, $set, $get): void
    {
        $total = (floatval($costPerMt) * floatval($get('est_total_mt')))
            + floatval($get('freight_cost'))
            + floatval($get('other_costs'));
        $set('total_cost', round($total, 2));
    }

    private static function recalcSellingTotal($sellingPerMt, $set, $get): void
    {
        $total = floatval($sellingPerMt) * floatval($get('est_total_mt'));
        $set('total_selling_price', round($total, 2));
    }
}
