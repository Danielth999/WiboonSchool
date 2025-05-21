<?php
$stmt = $conn->query("SELECT * FROM school_info ORDER BY id ASC LIMIT 1");
$infor = $stmt->fetch(PDO::FETCH_ASSOC);
$infor['updated_at'] = str_replace("-", "/", $infor['updated_at']);
$in_date = formatThaiDate($infor['updated_at']);
?>
<!-- Enhanced Announcement Bar -->
<div
    class="bg-gradient-to-r from-yellow-400 via-amber-500 to-yellow-400 text-white py-3 shadow-md relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute inset-0 bg-white opacity-10">
        <div class="absolute top-0 left-0 w-full h-1 bg-white opacity-20"></div>
        <div class="absolute bottom-0 left-0 w-full h-1 bg-black opacity-10"></div>
    </div>

    <div class="container mx-auto px-4">
        <div class="flex items-center">
            <!-- Icon -->
            <div class="mr-3 flex-shrink-0 hidden sm:block">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
            </div>

            <!-- Text container with better styling -->
            <div class="overflow-hidden rounded-lg flex-grow">
                <div class="flex items-center overflow-hidden">
                    <marquee behavior="scroll" direction="left" scrollamount="5" class="text-lg font-medium">
                        <span class="inline-flex items-center">
                            <?= htmlspecialchars($infor['value']) ?>
                            <span class="mx-3 text-white text-opacity-70">•</span>
                            <span class="text-base font-normal">ประกาศเมื่อวันที่
                                <?= htmlspecialchars($in_date) ?></span>
                        </span>
                    </marquee>
                </div>
            </div>
        </div>
    </div>
</div>