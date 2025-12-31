<table>
    <thead>
        <tr>
            <th>SL</th>
            <th>তারিখ</th>
            <th>এরিয়া</th>
            <th>নাম</th>
            <th>মোবাইল</th>
            <th>NID</th>
            <th>নোমিনি</th>
            <th>স্ট্যাটাস</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($members as $member)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $member->created_at->format('d-m-Y') }}</td>
                <td>{{ $member->area->name ?? 'N/A' }}</td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->phone }}</td>
                <td>{{ $member->nid }}</td>
                <td>{{ $member->nominee ?? 'N/A' }}</td>
                <td>{{ $member->status == 1 ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
