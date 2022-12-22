<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Posts</title>
</head>

<body>

    <div class="mt-9">
        <a href="{{ route('posts.create') }}"
            class="border  px-2 py-1 bg-blue-700 text-white rounded-md cursor-pointer">Create
            New</a>
        <a href="{{ route('posts.download-download') }}"
            class="px-2 py-1 bg-green-700 text-white rounded-md cursor-pointer">Download
            Downloads Images</a>
        <a href="{{ route('posts.download-all') }}"
            class="px-2 py-1 bg-yellow-400 text-black rounded-md cursor-pointer">Download
            All</a>
    </div>
    <div class="flex flex-col">
        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <table class="w-full">
                    <thead class="bg-white border-b">
                        <tr>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Id
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Name
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Content
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Image
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Download
                            </th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $p)
                            <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $p->id }}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    {{ $p->title }}
                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    {{ $p->description }}
                                </td>
                                <td>
                                    <img class="w-10 h-10 rounded-full" src="{{ $p->getFirstMediaUrl('images') }}"
                                        alt="Simple Image">

                                </td>
                                <td>
                                    <img class="w-10 h-10 rounded-full" src="{{ $p->getFirstMediaUrl('downloads') }}"
                                        alt="Download Image">
                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">

                                    <a href="{{ route('posts.download', $p->id) }}"
                                        class="px-2 py-1 bg-gray-700 text-white rounded-md cursor-pointer">Download</a>
                                    <a href="{{ route('posts.edit', $p->id) }}"
                                        class="px-2 py-1 bg-green-700 text-white rounded-md cursor-pointer">Edit</a>
                                    <form method="POST" action="{{ route('posts.destroy', $p->id) }}" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete?')">
                                        @csrf @method('Delete')
                                        <button type="submit"
                                            class="py-1 px-2 bg-red-700 text-white rounded-md cursor-pointer ml-2">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</body>

</html>
