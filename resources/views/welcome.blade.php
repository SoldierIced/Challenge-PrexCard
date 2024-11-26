<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex flex-col justify-center items-center bg-white min-h-[100vh]">
        <div class="mx-auto flex w-full mx-20 flex-col justify-center px-5 md:h-[unset] max-w-[520px] lg:px-6 xl:pl-0">
            <h2 class="mx-auto p-3  text-4xl font-bold">API</h2>
            <div class="relative flex w-full flex-col pt-[20px] md:pt-0">
                <div
                    class="rounded-lg border bg-card text-card-foreground shadow-sm mb-5 h-min max-w-full pt-8 pb-6 px-6 dark:border-zinc-800">
                    <p class="text-xl font-extrabold text-zinc-950 dark:text-white md:text-3xl mx-auto text-center ">
                        {{ env('APP_NAME') }}
                    </p>
                    <p class="font-normal text-zinc-950 mt-20 mx-auto w-max">
                        <a href="https://github.com/SoldierIced/Challenge-PrexCard" target="_blank"
                            class="text-brand-500 font-bold">See the documentation or the github repository</a>
                    </p>
                </div>

            </div>
        </div>
        <p class="font-normal text-zinc-950 mt-20 mx-auto w-max">
            Developed by
            <a href="https://www.linkedin.com/in/nehuenfortes/" target="_blank" class="text-brand-500 font-bold">Nehuen
                Fortes</a>
        </p>
    </div>
</body>


</html>
