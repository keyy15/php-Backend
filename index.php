<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="index.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Product Management</title>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold bg-blue-500 text-white py-4 text-center">Product Management</h1>

        <!-- Product Modal -->
        <div id="productModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">

            <div class="modal-container bg-white w-96 p-4 rounded shadow-lg fade-in">
                <h2 class="text-2xl font-bold mb-4">Add Product</h2>
                <form id="productForm">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="productId">
                            Product ID
                        </label>
                        <input type="text" id="productId" name="productId" class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="productName">
                            Product Name
                        </label>
                        <input type="text" id="productName" name="productName" class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="productQty">
                            Product Qty
                        </label>
                        <input type="text" id="productQty" name="productQty" class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="productDescription">
                            Product Description
                        </label>
                        <textarea id="productDescription" name="productDescription" class="w-full border rounded px-3 py-2" rows="4"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
                        <select id="category" name="productCategory" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <label for="">Choose a Category</label>
                            <option value="IPhone">IPhone</option>
                            <option value="Samsung">Samsung</option>
                            <option value="Real Mi">Real Mi</option>
                            <option value="Oppo">Oppo</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="productPrice">
                            Product Price
                        </label>
                        <input type="number" id="productPrice" name="productPrice" class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="productImage">
                            Product Image
                        </label>
                        <input type="file" id="productImage" name="productImage" class="w-full border rounded px-3 py-2">
                    </div>
                    <!-- <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="productDate" hidden>
                            Pro Date
                        </label>
                        <input type="date" id="productDate" name="productDate" class="w-full border rounded px-3 py-2">
                    </div> -->
                    <div class="text-center">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded add-Product">
                            Add Product
                        </button>
                        <button type="button" id="closeModalButton" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Product Table -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="text-center mb-4">
                <button id="addProductButton" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add Product
                </button>
                <input type="search" placeholder="Search..." class="py-2 px-4 rounded">
            </div>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="productTableBody">
                <thead class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            IMG
                        </th>
                        <!-- <th scope="col" class="px-6 py-3">
                            Pro ID
                        </th> -->
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Qty
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Create Time
                        </th>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-center">
                </tbody>
            </table>
        </div>

        <!-- <table id="productTableBody">
            <thead>
                <tr>
                    <th class="px-4 py-2">Product ID</th>
                    <th class="px-4 py-2">Product Name</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Image</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Centro comercial Moctezuma</td>
                    <td>Francisco Chang</td>
                    <td>Mexico</td>
                    <td>Centro comercial Moctezuma</td>
                    <td>Francisco Chang</td>
                    <td>Mexico</td>
                </tr>
            </tbody>
        </table> -->
    </div>
</body>
<script>
    // JavaScript code for handling the modal and table
    const addProductButton = document.getElementById("addProductButton");
    // const productModal = document.getElementById("productModal");
    const closeModalButton = document.getElementById("closeModalButton");
    // const productForm = document.getElementById("productForm");
    // const productTableBody = document.getElementById("productTableBody");
    // let productIdCounter = 1;

    addProductButton.addEventListener("click", () => {
        productModal.classList.remove("hidden");
    });

    closeModalButton.addEventListener("click", () => {
        productModal.classList.add("hidden");
    });

    // productForm.addEventListener("submit", (event) => {
    //     event.preventDefault();

    //     const productId = document.getElementById("productId").value;
    //     const productName = document.getElementById("productName").value;
    //     const productDescription = document.getElementById("productDescription").value;
    //     const productPrice = document.getElementById("productPrice").value;

    //     const newRow = `
    //             <tr>
    //                 <td class="px-4 py-2">${productIdCounter}</td>
    //                 <td class="px-4 py-2">${productId}</td>
    //                 <td class="px-4 py-2">${productName}</td>
    //                 <td class="px-4 py-2">${productDescription}</td>
    //                 <td class="px-4 py-2">$${productPrice}</td>
    //             </tr>
    //         `;

    //     productTableBody.innerHTML += newRow;

    //     productIdCounter++;
    //     productModal.classList.add("hidden");
    //     productForm.reset();
    // });
</script>

</html>