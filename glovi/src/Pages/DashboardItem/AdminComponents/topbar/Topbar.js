import React, {useState, useEffect} from "react";
import { Link } from "react-router-dom";

export default function Topbar() {
 

  return (
    <div style={{ background: "rgb(33 12 45)", height: "80px" }} className="shadow-md">
      <div className="mx-auto px-4 py-5 flex justify-between items-center">
        <div style={{marginTop: "-10px"}} className="flex items-center">
          <h1 className="text-bold text-3xl font-semibold text-white"><a href="/">GLOVI</a></h1>
        
        </div>
        <div className="ml-4 flex items-center md:ml-6">
        
     
         <Link to="/">
          <button
            className="p-1 rounded-full ml-4 text-gray-200 hover:text-green-500 focus:outline-none focus:ring focus:ring-offset-2 focus:ring-gray-500"
          
          >
            <span className="sr-only">Logout</span>
            <span className="font-medium">Logout</span>
          </button>
          </Link>
          <img
            className="h-8 w-8 rounded-full ml-6"
            src="https://ui-avatars.com/api/?name=Admin"
            alt=""
          />
        </div>
      </div>
    </div>
  );
}
