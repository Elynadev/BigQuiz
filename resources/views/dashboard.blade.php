
@extends('layouts.app')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-32 relative ">
    <!-- Images positionnées -->
    <img src="/images/rouge.jpg" alt="Image Haut Gauche" class="absolute w-[200px] ml-[90px] mt-[80px] top-0 left-0 h-[300px] animate-scale">
        <img src="/images/yn.jpg" alt="Image Haut Droit" class="absolute  mr-[90px] mt-[80px] top-0 right-0 w-32 h-32 animate-scale">
        <img src="/images/qu.jpg" alt="Image Bas Gauche" class="absolute ml-[500px] mt-[90px] bottom-0 left-0 w-32 h-32 animate-scale">
        <img src="/images/qn2.jpg" alt="Image Bas Droit" class="absolute mr-[220px] mb-[130px] bottom-0 right-0 w-32 h-32 animate-scale">

    <div class="max-w-7xl mx-auto  sm:px-6 lg:px-8">
        
            <div class="bg-white w-[600px] ml-[350px]  shadow-sm sm:rounded-lg">
                <img src="/images/quiz.jpg" alt="Quiz Image" class=" w-[300px]
                ml-[170px] bg-gray-300 m-4">
                    <h1 class="text-4xl font-bold ml-[130px] mb-4 mt-[30px]">Let's start the quiz!</h1>
                    <p class="mb-4 ml-[70px]">welcome to genius! the place where knowledge and fun meet!</p>
                    <p class="mb-4 ml-[80px]">Test your insight with various interesting questions.</p>
                </div>
            
        </div>
    </div>
   
    <div class="flex items-center justify-center bg-gray-100">
    <a href="/"
       class="mt-2 inline-block  ml-[300px] w-[300px] mr-32 bg-red-500 text-black px-6 py-3 text-center rounded-lg 
              hover:bg-red-300 animate-scale">
       Let's start game
    </a>
</div>

</div>
</x-app-layout>