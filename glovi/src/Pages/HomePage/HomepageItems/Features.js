import React from 'react';

export default function Features() {
  return (
    <>
      <section style={{ width: "60%" }} className='h-auto mx-auto mt-7'>

        <div className='mb-8 md:flex md:items-center'>
          <div className='md:w-1/2 md:pr-6 mb-6'>
            <h1 className='text-4xl font-bold mb-6 text-purple-900'>The world's easiest shipping platform</h1>
            <p className='text-gray-700 mb-6'>Easy. Simple Awesome. This intuitively easy shipping platform allows you to do all things shipping - ship, track, compare prices, schedule pickups, and more!</p>
          </div>
          <div className='md:w-1/2 md:flex md:justify-center'>
            <img className='mx-auto' style={{ width: "1000px" }} src="f1.svg" alt="" />
          </div>
        </div>

        <div className='mb-8 md:flex md:items-center'>
          <div className='md:w-full md:pr-6 mb-6'>
            <img className='mx-auto' style={{ width: "550px" }} src="f2.svg" alt="" />
          </div>
          <div className='md:w-full md:pl-6'>
            <h1 className='text-4xl font-bold mb-6 ml-6 text-purple-900'>Supercharge your shipping</h1>
            <p className='text-gray-700 mb-6 ml-6'>Leverage the power of Secureship's shipping platform with your own carrier accounts.</p>
          </div>
        </div>

        <div className='mb-8 md:flex md:items-center'>
          <div className='md:w-1/2 md:pr-6 mb-6'>
            <h1 className='text-4xl font-bold mb-6 text-purple-900'>The world's easiest shipping platform</h1>
            <p className='text-gray-700 mb-6'>Easy. Simple Awesome. This intuitively easy shipping platform allows you to do all things shipping - ship, track, compare prices, schedule pickups, and more!</p>
          </div>
          <div className='md:w-1/2 md:flex md:justify-center'>
            <img className='mx-auto' style={{ width: "1000px" }} src="f3.svg" alt="" />
          </div>
        </div>

        <div className='mb-8 md:flex md:items-center'>
          <div className='md:w-full md:pr-6 mb-6'>
            <img className='mx-auto' style={{ width: "1000px" }} src="f4.svg" alt="" />
          </div>
          <div className='md:w-full md:pl-6'>
            <h1 className='text-4xl font-bold ml-6 mb-6 text-purple-900'>The world's easiest shipping platform</h1>
            <p className='text-gray-700 ml-6 mb-6'>Easy. Simple Awesome. This intuitively easy shipping platform allows you to do all things shipping - ship, track, compare prices, schedule pickups, and more!</p>
          </div>
        </div>

      </section>
    </>
  )
}
