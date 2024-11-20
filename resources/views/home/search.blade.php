<style>
    .search-container {
        position: relative;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        border-radius: 50%;
        background-color: #fff;
        cursor: pointer;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .search-container.active {
        width: 300px;
        border-radius: 25px;
    }

    .search-input {
        position: absolute;
        left: 10px;
        width: 0;
        opacity: 0;
        border: none;
        outline: none;
        font-size: 16px;
        background: none;
        transition: all 0.3s ease;
    }

    .search-container.active .search-input {
        width: 250px;
        opacity: 1;
    }

    .search-icon {
        position: absolute;
        right: 15px;
        font-size: 20px;
        color: #666;
        transition: transform 0.3s ease;
        cursor: pointer;
    }

    .search-container.active .search-icon {
        transform: rotate(90deg);
    }
</style>

<body>
    <form action="{{ route('posts.searchHomepage') }}" method="GET">
        <div class="search-container" id="searchContainer">
            <input type="text" class="search-input" id="searchInput" name="query" placeholder="Search...">
            <span class="search-icon" id="searchIcon">&#128269;</span>
        </div>
    </form>

    <script>
        const searchContainer = document.getElementById('searchContainer');
        const searchInput = document.getElementById('searchInput');
        const searchIcon = document.getElementById('searchIcon');

        // Sự kiện click vào icon
        searchIcon.addEventListener('click', (event) => {
            event.stopPropagation(); // Ngăn chặn sự kiện click lan tới phần tử cha
            searchContainer.classList.toggle('active');
            if (searchContainer.classList.contains('active')) {
                searchInput.focus();
            }
        });

        // Ngăn khung tìm kiếm đóng khi click vào input
        searchInput.addEventListener('click', (event) => {
            event.stopPropagation();
        });

        // Đóng khung tìm kiếm khi click ra ngoài
        document.addEventListener('click', () => {
            if (searchContainer.classList.contains('active')) {
                searchContainer.classList.remove('active');
                searchInput.value = '';
            }
        });
    </script>
</body>
