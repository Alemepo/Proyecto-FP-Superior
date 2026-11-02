<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoutineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Routine::updateOrCreate([
            'name' => 'Rutina Mujeres',
            'gender' => 'female',
            'is_default' => true,
        ], [
            'description' => 'Rutina avanzada de 5 días enfocada en glúteos, piernas y tonificación general.',
            'exercises' => [
                [
                    'nombre' => 'Día 1: Piernas (Cuádriceps) y Glúteos',
                    'ejercicios' => [
                        [
                            'nombre' => 'Sentadilla',
                            'series' => '4',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/watch?v=dsCuiccYNGs'
                        ],
                        [
                            'nombre' => 'Prensa inclinada',
                            'series' => '4',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/watch?v=hl-EJUQ2yuc'
                        ],
                        [
                            'nombre' => 'Hip Thrust',
                            'series' => '4',
                            'repeticiones' => '8-10',
                            'video_url' => 'https://www.youtube.com/shorts/bup775DiMUE'
                        ],
                        [
                            'nombre' => 'Extensión de cuádriceps',
                            'series' => '3',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/shorts/S50jrJDzO4M'
                        ],
                        [
                            'nombre' => 'Abductores en máquina',
                            'series' => '3',
                            'repeticiones' => '15',
                            'video_url' => 'https://www.youtube.com/shorts/Vw32LcBYYrI'
                        ],
                        [
                            'nombre' => 'Zancadas caminando',
                            'series' => '3',
                            'repeticiones' => '10 (por pierna)',
                            'video_url' => 'https://www.youtube.com/shorts/6euuzRpp0g4'
                        ]
                    ]
                ],
                [
                    'nombre' => 'Día 2: Espalda, Brazos y Abdomen',
                    'ejercicios' => [
                        [
                            'nombre' => 'Jalón al pecho',
                            'series' => '4',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/shorts/NfLoMMokK4o'
                        ],
                        [
                            'nombre' => 'Remo en polea',
                            'series' => '4',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/shorts/PSg9G1ERnQo'
                        ],
                        [
                            'nombre' => 'Curl bíceps mancuerna',
                            'series' => '3',
                            'repeticiones' => '12',
                            'video_url' => 'https://www.youtube.com/shorts/ifU_iEAhOfA'
                        ],
                        [
                            'nombre' => 'Face pull',
                            'series' => '3',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/shorts/8AuopdtVuw4'
                        ],
                        [
                            'nombre' => 'Plancha',
                            'series' => '4',
                            'repeticiones' => '40-60 segundos',
                            'video_url' => 'https://www.youtube.com/shorts/4j8op027Ibk'
                        ],
                        [
                            'nombre' => 'Elevaciones de piernas',
                            'series' => '3',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/shorts/TDrcxNrcCVs'
                        ]
                    ]
                ],
                [
                    'nombre' => 'Día 3: Glúteos (Enfoque total)',
                    'ejercicios' => [
                        [
                            'nombre' => 'Hip Thrust pesado',
                            'series' => '4',
                            'repeticiones' => '6-8',
                            'video_url' => 'https://www.youtube.com/shorts/bup775DiMUE'
                        ],
                        [
                            'nombre' => 'Peso muerto rumano',
                            'series' => '4',
                            'repeticiones' => '8-10',
                            'video_url' => 'https://www.youtube.com/shorts/6euuzRpp0g4'
                        ],
                        [
                            'nombre' => 'Patada de glúteo en polea',
                            'series' => '3',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/shorts/Vw32LcBYYrI'
                        ],
                        [
                            'nombre' => 'Abductores',
                            'series' => '4',
                            'repeticiones' => '15-20',
                            'video_url' => 'https://www.youtube.com/shorts/Vw32LcBYYrI'
                        ],
                        [
                            'nombre' => 'Puente de glúteo',
                            'series' => '3',
                            'repeticiones' => '15',
                            'video_url' => 'https://www.youtube.com/shorts/bup775DiMUE'
                        ]
                    ]
                ],
                [
                    'nombre' => 'Día 4: Pecho, Hombros y Tríceps',
                    'ejercicios' => [
                        [
                            'nombre' => 'Press banca con mancuernas',
                            'series' => '4',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/shorts/48L0oQApm_0'
                        ],
                        [
                            'nombre' => 'Press militar',
                            'series' => '4',
                            'repeticiones' => '10',
                            'video_url' => 'https://www.youtube.com/shorts/8AuopdtVuw4'
                        ],
                        [
                            'nombre' => 'Elevaciones laterales',
                            'series' => '3',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/shorts/8AuopdtVuw4'
                        ],
                        [
                            'nombre' => 'Fondos en banco',
                            'series' => '3',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/shorts/48L0oQApm_0'
                        ],
                        [
                            'nombre' => 'Extensión de tríceps en polea',
                            'series' => '3',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/shorts/ifU_iEAhOfA'
                        ]
                    ]
                ],
                [
                    'nombre' => 'Día 5: Piernas (Femoral) y Glúteos + Abdomen',
                    'ejercicios' => [
                        [
                            'nombre' => 'Peso muerto rumano',
                            'series' => '4',
                            'repeticiones' => '8-10',
                            'video_url' => 'https://www.youtube.com/shorts/6euuzRpp0g4'
                        ],
                        [
                            'nombre' => 'Curl femoral',
                            'series' => '4',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/shorts/S50jrJDzO4M'
                        ],
                        [
                            'nombre' => 'Hip Thrust',
                            'series' => '4',
                            'repeticiones' => '10',
                            'video_url' => 'https://www.youtube.com/shorts/bup775DiMUE'
                        ],
                        [
                            'nombre' => 'Sentadilla búlgara',
                            'series' => '3',
                            'repeticiones' => '10 (por pierna)',
                            'video_url' => 'https://www.youtube.com/shorts/6euuzRpp0g4'
                        ],
                        [
                            'nombre' => 'Plancha lateral',
                            'series' => '3',
                            'repeticiones' => '30-40 segundos',
                            'video_url' => 'https://www.youtube.com/shorts/4j8op027Ibk'
                        ],
                        [
                            'nombre' => 'Escaladores',
                            'series' => '3',
                            'repeticiones' => '20 (por pierna)',
                            'video_url' => 'https://www.youtube.com/shorts/jIzWec7cSyc'
                        ]
                    ]
                ]
            ]
        ]);

        \App\Models\Routine::updateOrCreate([
            'name' => 'Rutina Hombres',
            'gender' => 'male',
            'is_default' => true,
        ], [
            'description' => 'Rutina PPL',
            'exercises' => [
                [
                    'nombre' => 'Día 1: Push (Pecho, Hombro, Tríceps)',
                    'ejercicios' => [
                        [
                            'nombre' => 'Press banca',
                            'series' => '4',
                            'repeticiones' => '6-8',
                            'video_url' => 'https://www.youtube.com/watch?v=rT7DgCr-3pg'
                        ],
                        [
                            'nombre' => 'Press inclinado mancuernas',
                            'series' => '4',
                            'repeticiones' => '8-10',
                            'video_url' => 'https://www.youtube.com/watch?v=8iPEnn-ltC8'
                        ],
                        [
                            'nombre' => 'Press militar',
                            'series' => '4',
                            'repeticiones' => '8-10',
                            'video_url' => 'https://www.youtube.com/watch?v=2yjwXTZQDDI'
                        ],
                        [
                            'nombre' => 'Elevaciones laterales',
                            'series' => '3',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/watch?v=kDqklk1ZESo'
                        ],
                        [
                            'nombre' => 'Fondos',
                            'series' => '3',
                            'repeticiones' => '8-12',
                            'video_url' => 'https://www.youtube.com/watch?v=2z8JmcrW-As'
                        ],
                        [
                            'nombre' => 'Extensión tríceps polea',
                            'series' => '3',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/watch?v=vB5OHsJ3EME'
                        ]
                    ]
                ],
                [
                    'nombre' => 'Día 2: Pull (Espalda, Bíceps)',
                    'ejercicios' => [
                        [
                            'nombre' => 'Dominadas',
                            'series' => '4',
                            'repeticiones' => '6-10',
                            'video_url' => 'https://www.youtube.com/watch?v=eGo4IYlbE5g'
                        ],
                        [
                            'nombre' => 'Jalón al pecho',
                            'series' => '4',
                            'repeticiones' => '8-12',
                            'video_url' => 'https://www.youtube.com/watch?v=CAwf7n6Luuc'
                        ],
                        [
                            'nombre' => 'Remo con barra',
                            'series' => '4',
                            'repeticiones' => '8-10',
                            'video_url' => 'https://www.youtube.com/watch?v=vT2GjY_Umpw'
                        ],
                        [
                            'nombre' => 'Remo en polea',
                            'series' => '3',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/watch?v=HJSVR_67OlM'
                        ],
                        [
                            'nombre' => 'Curl bíceps barra',
                            'series' => '3',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/watch?v=kwG2ipFRgfo'
                        ],
                        [
                            'nombre' => 'Curl martillo',
                            'series' => '3',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/watch?v=zC3nLlEvin4'
                        ]
                    ]
                ],
                [
                    'nombre' => 'Día 3: Legs (Piernas completas)',
                    'ejercicios' => [
                        [
                            'nombre' => 'Sentadilla',
                            'series' => '4',
                            'repeticiones' => '6-8',
                            'video_url' => 'https://www.youtube.com/watch?v=dsCuiccYNGs'
                        ],
                        [
                            'nombre' => 'Prensa',
                            'series' => '4',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/watch?v=hl-EJUQ2yuc'
                        ],
                        [
                            'nombre' => 'Peso muerto rumano',
                            'series' => '4',
                            'repeticiones' => '8-10',
                            'video_url' => 'https://www.youtube.com/watch?v=2SHsk9AzdjA'
                        ],
                        [
                            'nombre' => 'Curl femoral',
                            'series' => '3',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/watch?v=1Tq3QdYUuHs'
                        ],
                        [
                            'nombre' => 'Extensión cuádriceps',
                            'series' => '3',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/watch?v=YyvSfVjQeL0'
                        ],
                        [
                            'nombre' => 'Elevación de talones',
                            'series' => '4',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/watch?v=-M4-G8p8fmc'
                        ]
                    ]
                ],
                [
                    'nombre' => 'Día 4: Push',
                    'ejercicios' => [
                        [
                            'nombre' => 'Press banca mancuernas',
                            'series' => '4',
                            'repeticiones' => '8-10',
                            'video_url' => 'https://www.youtube.com/watch?v=VmB1G1K7v94'
                        ],
                        [
                            'nombre' => 'Press inclinado barra',
                            'series' => '4',
                            'repeticiones' => '8-10',
                            'video_url' => 'https://www.youtube.com/watch?v=SrqOu55lrYU'
                        ],
                        [
                            'nombre' => 'Elevaciones laterales',
                            'series' => '3',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/watch?v=kDqklk1ZESo'
                        ],
                        [
                            'nombre' => 'Pájaros',
                            'series' => '3',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/watch?v=pYcpY20QaE8'
                        ],
                        [
                            'nombre' => 'Extensión tríceps cuerda',
                            'series' => '3',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/watch?v=vB5OHsJ3EME'
                        ]
                    ]
                ],
                [
                    'nombre' => 'Día 5: Pull',
                    'ejercicios' => [
                        [
                            'nombre' => 'Jalón agarre estrecho',
                            'series' => '4',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/watch?v=CAwf7n6Luuc'
                        ],
                        [
                            'nombre' => 'Remo en máquina',
                            'series' => '4',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/watch?v=GZbfZ033f74'
                        ],
                        [
                            'nombre' => 'Face pull',
                            'series' => '3',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/watch?v=vj2w851ZHRM'
                        ],
                        [
                            'nombre' => 'Curl bíceps mancuerna',
                            'series' => '3',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/watch?v=ykJmrZ5v0Oo'
                        ],
                        [
                            'nombre' => 'Curl concentrado',
                            'series' => '3',
                            'repeticiones' => '12',
                            'video_url' => 'https://www.youtube.com/watch?v=Jvj2wV0vOYU'
                        ]
                    ]
                ],
                [
                    'nombre' => 'Día 6: Legs',
                    'ejercicios' => [
                        [
                            'nombre' => 'Sentadilla frontal',
                            'series' => '4',
                            'repeticiones' => '6-8',
                            'video_url' => 'https://www.youtube.com/watch?v=tlfGU4Lt1jM'
                        ],
                        [
                            'nombre' => 'Peso muerto',
                            'series' => '4',
                            'repeticiones' => '5-6',
                            'video_url' => 'https://www.youtube.com/watch?v=ytGaGIn3SjE'
                        ],
                        [
                            'nombre' => 'Zancadas',
                            'series' => '3',
                            'repeticiones' => '10 por pierna',
                            'video_url' => 'https://www.youtube.com/watch?v=QOVaHwm-Q6U'
                        ],
                        [
                            'nombre' => 'Curl femoral',
                            'series' => '3',
                            'repeticiones' => '10-12',
                            'video_url' => 'https://www.youtube.com/watch?v=1Tq3QdYUuHs'
                        ],
                        [
                            'nombre' => 'Gemelos sentado',
                            'series' => '4',
                            'repeticiones' => '12-15',
                            'video_url' => 'https://www.youtube.com/watch?v=gwLzBJYoWlI'
                        ]
                    ]
                ]
            ]
        ]);
    }
}