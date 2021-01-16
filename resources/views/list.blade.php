
<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> -->
        <div class="">
            @csrf
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th col-lg-4 width="100px">Title</th>
                        <th col-lg-4 width="200px">Last Content</th>
                        <th col-lg-4 width="200px">Current Content</th>
                        <th col-lg-4 width="100px">Watched</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userContents as $data)
                        <tr>
                            <td>{{ $data->contentName }}</td>
                            <td>{{ $data->lastContent }}</td>
                            <td>{{ $data->currentContent }}</td>
                            <td>
                                @if ( $data->watched == 1 )
                                    Watched
                                @else
                                    Not watched yet!
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
    </div>
</x-app-layout>




