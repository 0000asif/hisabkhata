<?php

namespace App\Exports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class MembersExport implements FromArray, WithHeadings, WithDrawings
{
    protected $members;

    public function __construct()
    {
        $this->members = Member::with('user', 'area')->get();
    }

    public function array(): array
    {
        $data = [];

        foreach ($this->members as $member) {
            $data[] = [
                $member->id,
                $member->user->name ?? 'N/A',
                $member->area->name ?? 'N/A',
                $member->joined_date,
                $member->date,
                $member->name,
                $member->phone,
                $member->address,
                $member->nid,
                $member->father_name,
                $member->guarantor,
                $member->nominee,
                $member->nominee_phone,
                $member->nominee_relation,
                $member->membership_fee,
                $member->status == 1 ? 'Active' : 'Inactive',
                $member->note,
                // For images we leave empty cells; drawings() will insert them
                '', '', '', '', '', ''
            ];
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'ID', 'User', 'Area', 'Joined Date', 'Date', 'Name', 'Phone', 'Address', 'NID', 'Father Name', 
            'Guarantor', 'Nominee', 'Nominee Phone', 'Nominee Relation', 'Membership Fee', 'Status', 'Note',
            'Member Photo', 'Nominee Photo', 'Signature', 'NID Front', 'NID Back'
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $row = 2; // data starts after header

        foreach ($this->members as $member) {
            $columns = [
                'member_photo' => 'R',
                'nominee_photo' => 'S',
                'signature' => 'T',
                'nid_front' => 'U',
                'nid_back' => 'V'
            ];

            foreach ($columns as $field => $col) {
                if ($member->$field && file_exists(public_path($member->$field))) {
                    $drawing = new Drawing();
                    $drawing->setName($field);
                    $drawing->setPath(public_path($member->$field));
                    $drawing->setHeight(60);
                    $drawing->setCoordinates($col . $row);
                    $drawings[] = $drawing;
                }
            }

            $row++;
        }

        return $drawings;
    }
}
