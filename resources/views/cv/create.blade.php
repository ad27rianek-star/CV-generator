<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Generator CV — stwórz swoje CV online</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 text-slate-900 antialiased">
        <div
            x-data="{
                template: 'classic',
                personal: {
                    first_name: '', last_name: '', title: '', email: '', phone: '', city: '', summary: '',
                },
                experience: [
                    { company: '', position: '', period: '', description: '' },
                ],
                education: [
                    { school: '', field: '', period: '' },
                ],
                skillsInput: '',
                get skills() {
                    return this.skillsInput.split(',').map(s => s.trim()).filter(Boolean);
                },
                addExperience() {
                    this.experience.push({ company: '', position: '', period: '', description: '' });
                },
                removeExperience(index) {
                    this.experience.splice(index, 1);
                },
                addEducation() {
                    this.education.push({ school: '', field: '', period: '' });
                },
                removeEducation(index) {
                    this.education.splice(index, 1);
                },
            }"
        >
            <header class="border-b border-slate-200 bg-white">
                <div class="mx-auto max-w-7xl px-6 py-4">
                    <h1 class="text-lg font-bold">Generator CV</h1>
                    <p class="text-sm text-slate-500">Wypełnij formularz, zobacz podgląd na żywo i pobierz gotowe CV jako PDF.</p>
                </div>
            </header>

            <form method="POST" action="{{ route('cv.download') }}" class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-6 py-8 lg:grid-cols-12">
                @csrf

                {{-- Form column --}}
                <div class="space-y-6 lg:col-span-5">
                    @if ($errors->any())
                        <div class="rounded-md border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <p class="font-medium">Popraw poniższe pola:</p>
                            <ul class="mt-1 list-inside list-disc">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Template picker --}}
                    <section class="rounded-lg border border-slate-200 bg-white p-5">
                        <h2 class="font-semibold">Szablon</h2>
                        <div class="mt-3 flex gap-3">
                            <label class="flex flex-1 cursor-pointer items-center justify-center rounded-md border px-3 py-2 text-sm"
                                   :class="template === 'classic' ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-slate-300 text-slate-600'">
                                <input type="radio" name="template" value="classic" x-model="template" class="sr-only">
                                Klasyczny
                            </label>
                            <label class="flex flex-1 cursor-pointer items-center justify-center rounded-md border px-3 py-2 text-sm"
                                   :class="template === 'modern' ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-slate-300 text-slate-600'">
                                <input type="radio" name="template" value="modern" x-model="template" class="sr-only">
                                Nowoczesny
                            </label>
                        </div>
                    </section>

                    {{-- Personal data --}}
                    <section class="rounded-lg border border-slate-200 bg-white p-5">
                        <h2 class="font-semibold">Dane osobowe</h2>
                        <div class="mt-3 grid grid-cols-2 gap-3">
                            <div class="col-span-1">
                                <label class="block text-xs font-medium text-slate-600">Imię</label>
                                <input type="text" name="personal[first_name]" x-model="personal.first_name" required
                                       class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none">
                            </div>
                            <div class="col-span-1">
                                <label class="block text-xs font-medium text-slate-600">Nazwisko</label>
                                <input type="text" name="personal[last_name]" x-model="personal.last_name" required
                                       class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-medium text-slate-600">Stanowisko / tytuł zawodowy</label>
                                <input type="text" name="personal[title]" x-model="personal.title" placeholder="np. Programista Full-Stack"
                                       class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none">
                            </div>
                            <div class="col-span-1">
                                <label class="block text-xs font-medium text-slate-600">E-mail</label>
                                <input type="email" name="personal[email]" x-model="personal.email" required
                                       class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none">
                            </div>
                            <div class="col-span-1">
                                <label class="block text-xs font-medium text-slate-600">Telefon</label>
                                <input type="text" name="personal[phone]" x-model="personal.phone"
                                       class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-medium text-slate-600">Miasto</label>
                                <input type="text" name="personal[city]" x-model="personal.city"
                                       class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-medium text-slate-600">Podsumowanie zawodowe</label>
                                <textarea name="personal[summary]" x-model="personal.summary" rows="3"
                                          class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none"></textarea>
                            </div>
                        </div>
                    </section>

                    {{-- Experience --}}
                    <section class="rounded-lg border border-slate-200 bg-white p-5">
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold">Doświadczenie zawodowe</h2>
                            <button type="button" @click="addExperience()" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">+ Dodaj</button>
                        </div>

                        <template x-for="(job, index) in experience" :key="index">
                            <div class="mt-4 space-y-2 border-t border-slate-100 pt-4 first:mt-3 first:border-0 first:pt-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="grid flex-1 grid-cols-2 gap-2">
                                        <input type="text" :name="`experience[${index}][company]`" x-model="job.company" placeholder="Firma"
                                               class="rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none">
                                        <input type="text" :name="`experience[${index}][position]`" x-model="job.position" placeholder="Stanowisko"
                                               class="rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none">
                                        <input type="text" :name="`experience[${index}][period]`" x-model="job.period" placeholder="np. 2022 – obecnie"
                                               class="col-span-2 rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none">
                                        <textarea :name="`experience[${index}][description]`" x-model="job.description" placeholder="Krótki opis obowiązków" rows="2"
                                                  class="col-span-2 rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none"></textarea>
                                    </div>
                                    <button type="button" @click="removeExperience(index)" class="mt-1 text-slate-400 hover:text-red-500" title="Usuń">✕</button>
                                </div>
                            </div>
                        </template>
                    </section>

                    {{-- Education --}}
                    <section class="rounded-lg border border-slate-200 bg-white p-5">
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold">Wykształcenie</h2>
                            <button type="button" @click="addEducation()" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">+ Dodaj</button>
                        </div>

                        <template x-for="(school, index) in education" :key="index">
                            <div class="mt-4 space-y-2 border-t border-slate-100 pt-4 first:mt-3 first:border-0 first:pt-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="grid flex-1 grid-cols-2 gap-2">
                                        <input type="text" :name="`education[${index}][school]`" x-model="school.school" placeholder="Uczelnia / szkoła"
                                               class="col-span-2 rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none">
                                        <input type="text" :name="`education[${index}][field]`" x-model="school.field" placeholder="Kierunek"
                                               class="rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none">
                                        <input type="text" :name="`education[${index}][period]`" x-model="school.period" placeholder="np. 2018 – 2022"
                                               class="rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none">
                                    </div>
                                    <button type="button" @click="removeEducation(index)" class="mt-1 text-slate-400 hover:text-red-500" title="Usuń">✕</button>
                                </div>
                            </div>
                        </template>
                    </section>

                    {{-- Skills --}}
                    <section class="rounded-lg border border-slate-200 bg-white p-5">
                        <h2 class="font-semibold">Umiejętności</h2>
                        <p class="mt-1 text-xs text-slate-500">Wpisz umiejętności oddzielone przecinkami.</p>
                        <input type="text" name="skills" x-model="skillsInput" placeholder="PHP, Laravel, JavaScript, SQL"
                               class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-indigo-400 focus:outline-none">
                    </section>

                    <button type="submit" class="w-full rounded-md bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">
                        Pobierz CV jako PDF
                    </button>
                </div>

                {{-- Live preview column --}}
                <div class="lg:col-span-7">
                    <div class="sticky top-8">
                        <p class="mb-3 text-sm font-medium text-slate-500">Podgląd na żywo</p>

                        <div class="mx-auto aspect-[210/297] w-full max-w-2xl overflow-y-auto bg-white shadow-lg ring-1 ring-slate-200">

                            {{-- Classic template preview --}}
                            <div x-show="template === 'classic'" class="p-10 font-serif text-slate-800">
                                <h1 class="text-3xl font-bold" x-text="(personal.first_name || 'Imię') + ' ' + (personal.last_name || 'Nazwisko')"></h1>
                                <p class="mt-1 text-lg text-slate-600" x-text="personal.title"></p>
                                <p class="mt-2 text-sm text-slate-500" x-text="[personal.email, personal.phone, personal.city].filter(Boolean).join(' · ')"></p>

                                <template x-if="personal.summary">
                                    <p class="mt-4 border-t border-slate-200 pt-4 text-sm leading-relaxed" x-text="personal.summary"></p>
                                </template>

                                <template x-if="experience.some(j => j.company || j.position)">
                                    <div class="mt-6 border-t border-slate-200 pt-4">
                                        <h2 class="text-sm font-bold tracking-wide uppercase">Doświadczenie zawodowe</h2>
                                        <template x-for="(job, index) in experience" :key="index">
                                            <div x-show="job.company || job.position" class="mt-3">
                                                <div class="flex items-baseline justify-between">
                                                    <p class="font-semibold" x-text="job.position"></p>
                                                    <p class="text-xs text-slate-500" x-text="job.period"></p>
                                                </div>
                                                <p class="text-sm text-slate-600" x-text="job.company"></p>
                                                <p class="mt-1 text-sm text-slate-600" x-text="job.description"></p>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                <template x-if="education.some(e => e.school || e.field)">
                                    <div class="mt-6 border-t border-slate-200 pt-4">
                                        <h2 class="text-sm font-bold tracking-wide uppercase">Wykształcenie</h2>
                                        <template x-for="(school, index) in education" :key="index">
                                            <div x-show="school.school || school.field" class="mt-3">
                                                <div class="flex items-baseline justify-between">
                                                    <p class="font-semibold" x-text="school.school"></p>
                                                    <p class="text-xs text-slate-500" x-text="school.period"></p>
                                                </div>
                                                <p class="text-sm text-slate-600" x-text="school.field"></p>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                <template x-if="skills.length">
                                    <div class="mt-6 border-t border-slate-200 pt-4">
                                        <h2 class="text-sm font-bold tracking-wide uppercase">Umiejętności</h2>
                                        <p class="mt-2 text-sm text-slate-600" x-text="skills.join(' · ')"></p>
                                    </div>
                                </template>
                            </div>

                            {{-- Modern template preview --}}
                            <div x-show="template === 'modern'" class="flex min-h-full">
                                <aside class="w-2/5 bg-indigo-900 p-6 text-indigo-50">
                                    <h1 class="text-xl font-bold" x-text="(personal.first_name || 'Imię') + ' ' + (personal.last_name || 'Nazwisko')"></h1>
                                    <p class="mt-1 text-sm text-indigo-200" x-text="personal.title"></p>

                                    <div class="mt-6 space-y-1 text-xs text-indigo-100">
                                        <p x-show="personal.email" x-text="personal.email"></p>
                                        <p x-show="personal.phone" x-text="personal.phone"></p>
                                        <p x-show="personal.city" x-text="personal.city"></p>
                                    </div>

                                    <template x-if="skills.length">
                                        <div class="mt-6">
                                            <h2 class="text-xs font-bold tracking-wide text-indigo-200 uppercase">Umiejętności</h2>
                                            <ul class="mt-2 space-y-1 text-xs text-indigo-100">
                                                <template x-for="skill in skills" :key="skill">
                                                    <li x-text="skill"></li>
                                                </template>
                                            </ul>
                                        </div>
                                    </template>
                                </aside>

                                <div class="w-3/5 p-6 text-slate-800">
                                    <template x-if="personal.summary">
                                        <p class="text-sm leading-relaxed" x-text="personal.summary"></p>
                                    </template>

                                    <template x-if="experience.some(j => j.company || j.position)">
                                        <div class="mt-5">
                                            <h2 class="text-sm font-bold tracking-wide text-indigo-700 uppercase">Doświadczenie</h2>
                                            <template x-for="(job, index) in experience" :key="index">
                                                <div x-show="job.company || job.position" class="mt-3">
                                                    <div class="flex items-baseline justify-between">
                                                        <p class="font-semibold" x-text="job.position"></p>
                                                        <p class="text-xs text-slate-500" x-text="job.period"></p>
                                                    </div>
                                                    <p class="text-sm text-slate-600" x-text="job.company"></p>
                                                    <p class="mt-1 text-sm text-slate-600" x-text="job.description"></p>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    <template x-if="education.some(e => e.school || e.field)">
                                        <div class="mt-5">
                                            <h2 class="text-sm font-bold tracking-wide text-indigo-700 uppercase">Wykształcenie</h2>
                                            <template x-for="(school, index) in education" :key="index">
                                                <div x-show="school.school || school.field" class="mt-3">
                                                    <div class="flex items-baseline justify-between">
                                                        <p class="font-semibold" x-text="school.school"></p>
                                                        <p class="text-xs text-slate-500" x-text="school.period"></p>
                                                    </div>
                                                    <p class="text-sm text-slate-600" x-text="school.field"></p>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
