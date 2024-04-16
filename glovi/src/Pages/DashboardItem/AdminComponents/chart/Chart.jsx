import React from "react";
import {
  LineChart,
  Line,
  XAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
} from "recharts";

export default function Chart({ title, data, grid }) {
  return (
    <div style={{  boxShadow: "rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset" }} className="bg-white mt-4 rounded-lg shadow-lg p-6">
      <h3 className="text-lg font-medium text-gray-900 mb-4">{title}</h3>
      <ResponsiveContainer width="100%" aspect={4 / 1}>
        <LineChart data={data}>
          <XAxis dataKey="name" stroke="black" />
          <Line type="monotone" dataKey="pending" stroke="#48bb78" />
          <Line type="monotone" dataKey="shipped" stroke="#f6ad55" />
          <Line type="monotone" dataKey="delivered" stroke="#4299e1" />
          <Tooltip />
          {grid && <CartesianGrid stroke="black" strokeDasharray="5 5" />}
        </LineChart>
      </ResponsiveContainer>
    </div>
  );
}
