<?php

namespace fireproof\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use fireproof\Item;
use fireproof\Project;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\File;

class ScheduleOrder implements FromCollection,WithHeadings,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $item = Item::orderBy('itemId','desc')->limit(5)->get();
        $j = 1;
        $i = 0;
        foreach($item as $items){
            // $totalpriceperdoorset = $item[$i]->DoorsetPrice + $item[$i]->IronmongaryPrice;
            // $DoorQuantity += $item[$i]->DoorQuantity;
            // $DoorsetPrice += $item[$i]->DoorsetPrice;
            // $IronmongaryPrice += $item[$i]->IronmongaryPrice;



            $Floor = $item[$i]->Floor;
            $DoorNumber = $item[$i]->DoorNumber;
            $DoorQuantity = $item[$i]->DoorQuantity;
            $SOHeight = $item[$i]->SOHeight;
            $SOWidth = $item[$i]->SOWidth;
            $SOWallThick = $item[$i]->SOWallThick;
            $DoorType = $item[$i]->DoorType;
            $DoorLeafFinish = $item[$i]->DoorLeafFinish;
            $DoorLeafFacing = $item[$i]->DoorLeafFacing;
            $LippingType = $item[$i]->LippingType;
            $LippingSpecies = $item[$i]->LippingSpecies;
            $LeafWidth1 = $item[$i]->LeafWidth1;
            $LeafWidth2 = $item[$i]->LeafWidth2;
            $LeafHeight = $item[$i]->LeafHeight;
            $LeafThickness = $item[$i]->LeafThickness;
            $Undercut = $item[$i]->Undercut;
            $Handing = $item[$i]->Handing;
            $OpensInwards = $item[$i]->OpensInwards;

            $GlassType = $item[$i]->GlassType;

            $FrameMaterial = $item[$i]->FrameMaterial;
            $FrameType = $item[$i]->FrameType;
            $FrameFinish = $item[$i]->FrameFinish;
            $ExtLiner = $item[$i]->ExtLiner;
            $ExtLinerSize = $item[$i]->ExtLinerSize;

            $IntumescentSeal = $item[$i]->IntumescentSeal;

            $ArchitraveMaterial = $item[$i]->ArchitraveMaterial;
            $ArchitraveType = $item[$i]->ArchitraveType;
            $ArchitraveFinish = $item[$i]->ArchitraveFinish;
            $ArchitraveSetQty = $item[$i]->ArchitraveSetQty;

            $IronmongerySet = $item[$i]->IronmongerySet;
            $rWdBRating = $item[$i]->rWdBRating;
            $FireRating = $item[$i]->FireRating;
            $COC = $item[$i]->COC;
            $SpecialFeatureRefs = $item[$i]->SpecialFeatureRefs;
            $DoorsetPrice = $item[$i]->DoorsetPrice;
            $IronmongaryPrice = $item[$i]->IronmongaryPrice;
            $totalpriceperdoorset = $item[$i]->totalpriceperdoorset;
            
            $data[] = array(
                $j,
                $Floor,
                $DoorNumber,
                'description',
                $DoorQuantity,
                $SOHeight,
                $SOWidth,
                $SOWallThick,
                $DoorType,
                $DoorLeafFinish,
                $DoorLeafFacing,
                $LippingType.'-'.$LippingSpecies,
                $LeafWidth1,
                $LeafWidth2,
                $LeafHeight,
                $LeafThickness,
                $Undercut,
                $Handing,
                $OpensInwards,

                'leaf 1 size',
                'leaf 2 size',
                $GlassType,

                'OA screen dim',
                'on screen glass',

                $FrameMaterial,
                $FrameType,
                'frame size',
                $FrameFinish,
                $ExtLiner,
                $ExtLinerSize,

                $IntumescentSeal,

                $ArchitraveMaterial,
                $ArchitraveType,
                'Architrave size',
                $ArchitraveFinish,
                $ArchitraveSetQty,

                $IronmongerySet,
                $rWdBRating,
                $FireRating,
                $COC,
                $SpecialFeatureRefs,
                $DoorsetPrice,
                $IronmongaryPrice,
                $totalpriceperdoorset,


            );
            $i++;
            $j++;
        }

       
        return collect($data);     
        // return collect($data);     
    }
    public function headings(): array
    {   
        $a = [
            'Line No.',
            'Floor',
            'Door No.',
            'Door Description',
            'Door Qty.',
            'S.O Height',
            'S.O Width',
            'S.O Wall Thick',
            'Door Type',
            'Door Leaf Finish',
            'Door Leaf Facing',
            'Lipping Type - LippingSpecies',            
            'Leaf Width 1',
            'Leaf Width 2',
            'Leaf Height',
            'Leaf Thick',
            'Undercut',
            'Handing',
            'Opens Inwards',

            'Leaf 1 Size',
            'Leaf 2 Size',
            'Glass Type',

            'OA Screen Dims',
            'Screen Glass',


            'Material',
            'Type',
            'Size',
            'Finish',
            'Ext-Liner',
            'Ext-Liner Size',

            'Intumescent Seal',

            'Material',
            'Type',
            'Size',
            'Finish',
            'Set Qty',
        
            'Iron. Set',
            'rW Db Rating',
            'Fire Rating',
            'CoC Type',
            'Special Feature Refs',
            'Doorset Price',
            'Ironmongery Price',
            'Total Price per Doorset'
           
        ];
        $pro = ['Project:'];
        $cust = ['Customer:'];
        $sch = ['Schedule:'];
        $dt = ['Date:'];
        $rev = ['Revision:'];
        $a1 = [];
        $a2 = [];
        $a3 = [];
        $a4 = [];
        $d = [$pro,$cust,$sch,$dt,$rev,$a1,$a2,$a3,$a4, $a];
        return $d;



        // $ProjectDetails = [
        //     [
        //       'Project' => 'Project'
        //     ],
        //     [
        //       'Customer' => 'Customer'
        //     ]
        // ];
        // $d = [$ProjectDetails,     $a];


        
    }
    public function registerEvents(): array
    {
        
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A10:AR10'; // All headers
                // $cellRange->setFontWeight('bold');
                // $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                    'background' => [
                        'color'=> '#000000'
                    ],                 
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => 'FF0000'],
                        ],
                    ],
                   
                ];


                $project = Project::first(); 

                $date = date('d-m-Y');
                $event->sheet->setCellValue('D1', $project->ProjectName);
                $event->sheet->setCellValue('D2', 'Northstone (NI) Ltd T/A Farrans Construction');
                $event->sheet->setCellValue('D3', 'Sales Doorset Schedule');
                $event->sheet->setCellValue('D4', $date);
                $event->sheet->setCellValue('D5', 'A');
            
                
                
                // $event->sheet->getDelegate()->mergeCells([
                //     'A1:C1',
                //     'A2:C2',
                //     'A3:C3',
                //     'A4:C4',
                //     'A5:C5',
                // ]);
                
                
                $event->sheet->setCellValue('AP1', 'Datim Supplies');
                $event->sheet->mergeCells('AP1:AR1');                
                $event->sheet->getStyle("AP1:AR1")->getFont()->setSize(18)->setBold(true);





                $rr = 'Foxwood Industrial Park Foxwood Road Chesterfield Derbyshire S41 9RN';
                $r2 = 'Telephone: 01246 572277';
                $r3 = 'Email: sales@datim.co.uk';
                $r4 = 'Web: www.datim.co.uk';
                
                
                $cellRange3 = 'AP2:AR8';
                $styleArray3 = [
                    'alignment' => [
                        // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,

                        // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                        // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ]
                ];
                $event->sheet->setCellValue('AP2', $rr);
                // $event->sheet->getStyle("AP2:AR8")->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('AP2:AR8')->getAlignment()->setWrapText(true);
                $event->sheet->mergeCells('AP2:AR5');   
                $event->sheet->getDelegate()->getStyle($cellRange3)->applyFromArray($styleArray3);
                // $event->sheet->getStyle("AP2:AR8")->getAlignment('top');

                $event->sheet->mergeCells('AP6:AR6');
                $event->sheet->setCellValue('AP6', $r2);

                $event->sheet->mergeCells('AP7:AR7');
                $event->sheet->setCellValue('AP7', $r3);

                $event->sheet->mergeCells('AP8:AR8');
                $event->sheet->setCellValue('AP8', $r4);


                // $event->sheet->getDelegate()->getStyle('AP2')->applyFromArray($styleArray2);
                // $event->sheet->getStyle("AP2")->getFont()->setSize(10)->setAlignment('center');
                // $event->sheet->setCellValue('AP6', 'Telephone: 01246 572277');

                // $event->sheet->getStyle("AP2")->getAlignment()->setWrapText(true);
                // $event->sheet->setPath(public_path('images/companylogo.png'));

                // Image Show In Excel
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setName('Logo');
                    $drawing->setDescription('Logo');
                    $drawing->setPath(public_path('images/strebord.png'));
                    $drawing->setCoordinates('AD1');
                    $drawing->setHeight(90);
                    $drawing->setWidth(250);
                    $drawing->setOffsetX(5);
                    $drawing->setOffsetY(5);
                    $drawing->setWorksheet($event->sheet->getDelegate());


                $event->sheet->mergeCells('A1:C1');
                $event->sheet->mergeCells('A2:C2');
                $event->sheet->mergeCells('A3:C3');
                $event->sheet->mergeCells('A4:C4');
                $event->sheet->mergeCells('A5:C5');
                $event->sheet->getStyle("A1:C1")->getFont()->setSize(18)->setBold(true);
                $event->sheet->getStyle("A2:A2")->getFont()->setSize(18)->setBold(true);
                $event->sheet->getStyle("A3:A3")->getFont()->setSize(18)->setBold(true);
                $event->sheet->getStyle("A4:A4")->getFont()->setSize(18)->setBold(true);
                $event->sheet->getStyle("A5:A5")->getFont()->setSize(18)->setBold(true);

                $event->sheet->mergeCells('D1:K1');
                $event->sheet->mergeCells('D2:K2');
                $event->sheet->mergeCells('D3:K3');
                $event->sheet->mergeCells('D4:K4');
                $event->sheet->mergeCells('D5:K5');
                $event->sheet->getStyle("D1:K1")->getFont()->setSize(18);
                $event->sheet->getStyle("D2:K2")->getFont()->setSize(18);
                $event->sheet->getStyle("D3:K3")->getFont()->setSize(18);
                $event->sheet->getStyle("D4:K4")->getFont()->setSize(18);
                $event->sheet->getStyle("D5:K5")->getFont()->setSize(18);


                // $event->sheet->getStyle("A10:AS10")->getStartColor(' #FFFFFF')->setARGB('#FFFFFF');

                $event->sheet->getStyle("A10:AS10")->getAlignment()->setTextRotation(90)->setWrapText(true);
                $event->sheet->getDelegate()->getRowDimension(10)->setRowHeight(60);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);

                // $event->sheet->getDelegate()->getStyle("A10:AS10")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle("AP11")->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FF17a2b8');
            },      
        ];
    }
}
