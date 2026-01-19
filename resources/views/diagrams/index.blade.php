{{-- resources/views/diagrams/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Mis Diagramas UML') }}
            </h2>
            <a href="{{ route('diagrams.editor') }}"
               class="px-4 py-2 font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                ➕ Nuevo Diagrama
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            {{-- Estadísticas rápidas --}}
            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-4">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                    <span class="font-semibold text-blue-600">📊</span>
                                </div>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['total'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                    <span class="font-semibold text-green-600">🔒</span>
                                </div>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Privados</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['private'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-8 h-8 bg-purple-100 rounded-full">
                                    <span class="font-semibold text-purple-600">🤝</span>
                                </div>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Compartidos</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['shared'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-8 h-8 bg-orange-100 rounded-full">
                                    <span class="font-semibold text-orange-600">📝</span>
                                </div>
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Templates</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['templates'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filtros y búsqueda --}}
            <div class="mb-6 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="{{ route('diagrams.index') }}" class="space-y-4 sm:space-y-0 sm:flex sm:items-center sm:space-x-4">
                        <div class="flex-1">
                            <input type="text"
                                   name="search"
                                   value="{{ $filters['search'] }}"
                                   placeholder="Buscar por título o descripción..."
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <select name="visibility" class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">Todas las visibilidades</option>
                                <option value="private" {{ $filters['visibility'] === 'private' ? 'selected' : '' }}>Privados</option>
                                <option value="shared" {{ $filters['visibility'] === 'shared' ? 'selected' : '' }}>Compartidos</option>
                                <option value="public" {{ $filters['visibility'] === 'public' ? 'selected' : '' }}>Públicos</option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox"
                                   name="templates"
                                   id="templates"
                                   value="1"
                                   {{ $filters['is_template'] ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="templates" class="ml-2 text-sm text-gray-700">Solo templates</label>
                        </div>

                        <div class="flex space-x-2">
                            <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white transition-colors bg-gray-600 rounded-md hover:bg-gray-700">
                                🔍 Filtrar
                            </button>
                            <a href="{{ route('diagrams.index') }}"
                               class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-300 rounded-md hover:bg-gray-400">
                                ✖️ Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Lista de diagramas --}}
            @if($diagrams->count() > 0)
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($diagrams as $diagram)
                        <div class="overflow-hidden transition-shadow bg-white shadow-sm sm:rounded-lg hover:shadow-md">
                            <div class="p-6">
                                {{-- Header del diagrama --}}
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900 truncate">
                                            {{ $diagram->title }}
                                        </h3>
                                        @if($diagram->description)
                                            <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                                {{ Str::limit($diagram->description, 100) }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Indicador de visibilidad --}}
                                    <div class="flex-shrink-0 ml-4">
                                        @if($diagram->visibility === 'private')
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full">
                                                🔒 Privado
                                            </span>
                                        @elseif($diagram->visibility === 'shared')
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                                                🤝 Compartido
                                            </span>
                                        @elseif($diagram->visibility === 'public')
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                                🌍 Público
                                            </span>
                                        @endif

                                        @if($diagram->is_template)
                                            <span class="inline-flex items-center px-2 py-1 ml-2 text-xs font-medium text-orange-800 bg-orange-100 rounded-full">
                                                📝 Template
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Estadísticas del diagrama --}}
                                <div class="flex items-center mb-4 space-x-4 text-sm text-gray-500">
                                    <span class="flex items-center">
                                        <span class="w-2 h-2 mr-1 bg-blue-500 rounded-full"></span>
                                        {{ $diagram->elements_count }} elementos
                                    </span>
                                    <span class="flex items-center">
                                        <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
                                        {{ $diagram->classes_count }} clases
                                    </span>
                                    <span class="flex items-center">
                                        <span class="w-2 h-2 mr-1 bg-purple-500 rounded-full"></span>
                                        v{{ $diagram->version }}
                                    </span>
                                </div>

                                {{-- Fechas --}}
                                <div class="mb-4 text-xs text-gray-400">
                                    <div>Creado: {{ $diagram->created_at->format('d/m/Y H:i') }}</div>
                                    @if($diagram->last_saved_at)
                                        <div>Guardado: {{ $diagram->last_saved_at->diffForHumans() }}</div>
                                    @endif
                                </div>

                                {{-- Botones de acción --}}
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('diagrams.editor', $diagram->id) }}"
                                       class="px-3 py-1 text-sm font-medium text-white transition-colors bg-blue-600 rounded hover:bg-blue-700">
                                        ✏️ Editar
                                    </a>

                                    {{-- <a href="{{ route('diagrams.show', $diagram->id) }}"
                                       class="px-3 py-1 text-sm font-medium text-white transition-colors bg-gray-600 rounded hover:bg-gray-700">
                                        👁️ Ver
                                    </a> --}}

                                    <form method="POST" action="{{ route('diagrams.duplicate', $diagram->id) }}" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="px-3 py-1 text-sm font-medium text-white transition-colors bg-green-600 rounded hover:bg-green-700">
                                            📋 Clonar
                                        </button>
                                    </form>

                                    @if($diagram->user_id === auth()->id())
                                        <form method="POST" action="{{ route('diagrams.destroy', $diagram->id) }}"
                                              class="inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este diagrama?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 text-sm font-medium text-white transition-colors bg-red-600 rounded hover:bg-red-700">
                                                🗑️ Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Paginación --}}
                <div class="mt-6">
                    {{ $diagrams->appends(request()->query())->links() }}
                </div>
            @else
                {{-- Estado vacío --}}
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full">
                            <span class="text-4xl text-gray-400">📊</span>
                        </div>

                        <h3 class="mb-2 text-lg font-medium text-gray-900">No tienes diagramas aún</h3>
                        <p class="mb-6 text-gray-600">Comienza creando tu primer diagrama de clases UML</p>

                        <a href="{{ route('diagrams.editor') }}"
                           class="inline-flex items-center px-6 py-3 font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                            ➕ Crear mi primer diagrama
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Notificaciones --}}
    @if (session('success'))
        <div class="fixed z-50 px-6 py-3 text-white bg-green-500 rounded-lg shadow-lg bottom-4 right-4"
             x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transform transition-all duration-300"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-transition:leave="transform transition-all duration-300"
             x-transition:leave-start="translate-x-0 opacity-100"
             x-transition:leave-end="translate-x-full opacity-0">
            <div class="flex items-center space-x-2">
                <span class="text-lg">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
</x-app-layout>
