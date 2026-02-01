@media (max-width: 768px) {
    .filter-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 85vh;
        z-index: 99999;
        background-color: white;
        transform: translateY(100%);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
        margin-top: 15vh;
        box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1), 0 -2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .filter-sidebar.active {
        transform: translateY(0);
    }
    .filter-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 99998;
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    .filter-buttons {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        background-color: white;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 0.75rem;
        z-index: 100000;
        box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.05);
    }
}

/* Update z-index for other elements */
#primary-nav {
    z-index: 99997;
}
#secondary-nav {
    z-index: 99996;
}
.main-content {
    position: relative;
    z-index: 1;
}
.pet-grid {
    position: relative;
    z-index: 1;
}
.footer {
    position: relative;
    z-index: 1;
}

/* Filter button styles */
#filter-button {
    position: fixed;
    bottom: 4rem;
    left: 1rem;
    z-index: 1000000;
    background-color: #3b82f6;
    color: white;
    padding: 0.75rem;
    border-radius: 9999px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.2s ease;
}
#filter-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 8px -1px rgba(0, 0, 0, 0.15), 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

<!-- Mobile Filter Button -->
<button id="filter-button" class="md:hidden">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
    </svg>
</button> 