import { createFileRoute } from "@tanstack/react-router";
import { Button } from "primereact/button";

export const Route = createFileRoute("/")({
  component: Index,
});

function Index() {
  return (
    <div className="p-2">
      <h3>
        <Button label="Home" />
      </h3>
    </div>
  );
}
