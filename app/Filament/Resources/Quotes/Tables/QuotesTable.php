<?php

namespace App\Filament\Resources\Quotes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inquiry.id')
                    ->label('Inquiry')
                    ->formatStateUsing(fn ($state) => 'INQ-' . str_pad($state, 3, '0', STR_PAD_LEFT))
                    ->sortable(),
                TextColumn::make('inquiry.user.name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('inquiry.grade')
                    ->label('Grade'),
                TextColumn::make('selling_price_per_mt')
                    ->label('Sell Price / MT')
                    ->formatStateUsing(fn ($state) => 'RM ' . number_format($state, 2))
                    ->sortable(),
                TextColumn::make('total_selling_price')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => 'RM ' . number_format($state, 2))
                    ->sortable(),
                TextColumn::make('valid_until')
                    ->label('Valid Until')
                    ->date()
                    ->sortable(),
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
                TextColumn::make('approved_at')
                    ->label('Approved At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft'    => 'Draft',
                        'sent'     => 'Sent',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'expired'  => 'Expired',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
