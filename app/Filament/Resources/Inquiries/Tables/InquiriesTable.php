<?php

namespace App\Filament\Resources\Inquiries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->formatStateUsing(fn ($state) => 'INQ-' . str_pad($state, 3, '0', STR_PAD_LEFT))
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('grade')
                    ->label('Grade')
                    ->searchable(),
                TextColumn::make('width_mm')
                    ->label('Width')
                    ->formatStateUsing(fn ($state) => $state . ' mm')
                    ->sortable(),
                TextColumn::make('thickness_mm')
                    ->label('Thickness')
                    ->formatStateUsing(fn ($state) => $state . ' mm')
                    ->sortable(),
                TextColumn::make('quantity_coils')
                    ->label('Qty (coils)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new'       => 'info',
                        'reviewing' => 'warning',
                        'quoted'    => 'warning',
                        'approved'  => 'success',
                        'cancelled' => 'danger',
                        default     => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'new'       => 'New',
                        'reviewing' => 'Reviewing',
                        'quoted'    => 'Quoted',
                        'approved'  => 'Approved',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->recordActions([
                EditAction::make()->label('Quote / View'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
