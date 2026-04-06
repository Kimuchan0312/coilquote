<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Customer')
                    ->components([
                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('status')
                            ->options([
                                'new'       => 'New',
                                'reviewing' => 'Reviewing',
                                'quoted'    => 'Quoted',
                                'approved'  => 'Approved',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('new')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Coil Specification')
                    ->components([
                        TextInput::make('grade')
                            ->label('Grade / Spec')
                            ->placeholder('e.g. SS304, GI AZ150, HR A36')
                            ->required(),
                        TextInput::make('delivery_terms')
                            ->label('Delivery Terms')
                            ->placeholder('e.g. CIF Port Klang, FOB Origin')
                            ->required(),
                        TextInput::make('width_mm')
                            ->label('Width (mm)')
                            ->numeric()
                            ->suffix('mm')
                            ->required(),
                        TextInput::make('thickness_mm')
                            ->label('Thickness (mm)')
                            ->numeric()
                            ->suffix('mm')
                            ->required(),
                        TextInput::make('coil_weight_kg')
                            ->label('Est. Coil Weight (kg)')
                            ->numeric()
                            ->suffix('kg'),
                        TextInput::make('quantity_coils')
                            ->label('Quantity (coils)')
                            ->numeric()
                            ->required(),
                        TextInput::make('preferred_origin')
                            ->label('Preferred Origin')
                            ->placeholder('e.g. Japan, Korea — or leave blank')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Documents & Remarks')
                    ->components([
                        CheckboxList::make('required_documents')
                            ->label('Required Documents')
                            ->options([
                                'mill_cert'   => 'Mill Certificate (3.1B)',
                                'packing_list' => 'Packing List',
                                'co'          => 'Certificate of Origin (CO)',
                                'invoice'     => 'Commercial Invoice',
                            ])
                            ->columns(2),
                        Textarea::make('remarks')
                            ->label('Customer Remarks')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
