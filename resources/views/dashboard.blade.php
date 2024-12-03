@extends('layouts.app')
@section('content')


    <div class="py-32 relative ">
    <!-- Images positionnées -->
    <img src="/images/rouge.png" alt="Image Haut Gauche" class="absolute w-[200px] ml-[90px] mt-[80px] top-0 left-0 h-[300px] animate-scale">
        <img src="/images/yesno.png" alt="Image Haut Droit" class="absolute  mr-[90px] mt-[80px] top-0 right-0 w-32 h-32 ">
        <img src="/images/violet.png" alt="Image Bas Gauche" class="absolute ml-[500px] mt-[90px] bottom-0 left-0 w-32 h-32 animate-scale">
        <img src="/images/qn.png" alt="Image Bas Droit" class="absolute mr-[220px] mb-[130px] bottom-0 right-0 w-32 h-32 animate-scale">

    <div class="max-w-7xl mx-auto  sm:px-6 lg:px-8">
        
            <div class="bg-white w-[600px] ml-[350px]  shadow-sm sm:rounded-lg">
                <img src="/images/quiz.png" alt="Quiz Image" class=" w-[300px]
                ml-[170px] bg-gray-300 m-4">
                <h1 class="text-4xl font-bold ml-[130px] mb-4 mt-[30px]">Commençons le quiz !</h1> 
                <p class="mb-4 ml-[200px]">Bienvenue chez Genius !</p>
                <p class="mb-4 ml-[120px]">   L'endroit où la connaissance et le plaisir se rencontrent !</p>
                <p class="mb-4 ml-[100px]">Testez vos connaissances avec diverses questions intéressantes.</p> 
             </div>
            
        </div>
    </div>
   
    <div class="flex items-center justify-center bg-gray-100">
    <a href="/answer"
       class="mt-2 inline-block  ml-[300px] w-[300px] mr-32 bg-blue-500 text-black px-6 py-3 text-center rounded-lg 
              hover:bg-blue-300 animate-scale">
       Let's start game
    </a>
</div>

</div>
@endsection