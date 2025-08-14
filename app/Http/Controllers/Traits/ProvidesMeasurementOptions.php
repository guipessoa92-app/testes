<?php

namespace App\Http\Controllers\Traits;

trait ProvidesMeasurementOptions
{
    protected function getMeasurementOptions(): array
    {
        return [
            'weight' => [
                'label' => 'Peso',
                'columns' => ['weight' => ['label' => 'Peso (kg)', 'color' => '#4f46e5']] // Indigo
            ],
            'gluteos' => [
                'label' => 'Glúteos',
                'columns' => ['gluteos' => ['label' => 'Glúteos (cm)', 'color' => '#7c3aed']] // Violet
            ],
            'biceps_contracted' => [
                'label' => 'Bíceps (Contraído)',
                'columns' => [
                    'biceps_right_contracted' => ['label' => 'Direito (cm)', 'color' => '#3b82f6'], // Blue
                    'biceps_left_contracted' => ['label' => 'Esquerdo (cm)', 'color' => '#ef4444']  // Red
                ]
            ],
            'biceps_relaxed' => [
                'label' => 'Bíceps (Relaxado)',
                'columns' => [
                    'biceps_right_relaxed' => ['label' => 'Direito (cm)', 'color' => '#3b82f6'],
                    'biceps_left_relaxed' => ['label' => 'Esquerdo (cm)', 'color' => '#ef4444']
                ]
            ],
            'thigh' => [
                'label' => 'Coxa',
                'columns' => [
                    'thigh_right' => ['label' => 'Direita (cm)', 'color' => '#3b82f6'],
                    'thigh_left' => ['label' => 'Esquerda (cm)', 'color' => '#ef4444']
                ]
            ],
            'calf' => [
                'label' => 'Panturrilha',
                'columns' => [
                    'calf_right' => ['label' => 'Direita (cm)', 'color' => '#3b82f6'],
                    'calf_left' => ['label' => 'Esquerda (cm)', 'color' => '#ef4444']
                ]
            ],
            'forearm' => [
                'label' => 'Antebraço',
                'columns' => [
                    'forearm_right' => ['label' => 'Direito (cm)', 'color' => '#3b82f6'],
                    'forearm_left' => ['label' => 'Esquerdo (cm)', 'color' => '#ef4444']
                ]
            ],
            'chest' => [
                'label' => 'Peito',
                'columns' => ['chest' => ['label' => 'Peito (cm)', 'color' => '#14b8a6']] // Teal
            ],
            'shoulders' => [
                'label' => 'Ombros',
                'columns' => ['shoulders' => ['label' => 'Ombros (cm)', 'color' => '#f97316']] // Orange
            ],
            'waist' => [
                'label' => 'Cintura',
                'columns' => ['waist' => ['label' => 'Cintura (cm)', 'color' => '#84cc16']] // Lime
            ],
        ];
    }
}