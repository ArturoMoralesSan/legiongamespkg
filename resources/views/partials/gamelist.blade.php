<div class="game-list">
    <div class="gamelist-header mb-3">
        <h6 class="gamelist--title mb-0">
            <i class="fa-solid fa-gamepad"></i>
            Últimos juegos añadidos
        </h6>

        <a href="{{ url('juegos') }}" class="see-more">
            Encontrar más
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    @foreach($games as $game)
        <div class="game-row">
             {{-- IMAGEN --}}
             <div class="gamelist-container d-flex">
                <div class="game-image">
                @if($game->image)
                    <img
                        src="{{ asset('uploads/games/' . $game->image) }}"
                        alt="{{ $game->title }}"
                    >
                @else
                    <div class="game-image-placeholder">
                        <i class="fa-solid fa-gamepad"></i>
                    </div>
                @endif
                </div>
                {{-- MAIN INFO --}}
                <div class="game-main">
                    {{-- TITLE --}}
                    <h4 class="game-title">
                        {{ $game->title }}
                    </h4>
                    {{-- SIZE --}}
                    @if($game->size_mb)
                        <p class="game-size">
                            {{ $game->size_mb }}
                        </p>
                    @endif
                    {{-- TAGS --}}
                    <div class="game-tags tag-cloud">
                        {{-- PLATFORMS --}}
                        @if($game->platforms)
                            @foreach($game->platforms as $platform)
                                <span class="tag small">
                                    {{ $platform->name }}
                                </span>
                            @endforeach
                        @endif
                        {{-- CATEGORIES --}}
                        @if($game->categories)
                            @foreach($game->categories as $category)
                                <span class="tag small">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>
             </div>
            {{-- ACTIONS --}}
            <div class="game-actions">
                <a
                    href="{{ route('games.show', $game->id) }}"
                    class="details-btn"
                    title="Ver detalles"
                    aria-label="Ver detalles"
                >
                    <i class="fa-solid fa-eye"></i>
                </a>
            </div>
        </div>
    @endforeach
</div>