import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { PrimeReactProvider } from "primereact/api";
import Tailwind from "primereact/passthrough/tailwind";

const queryClient = new QueryClient();
const GlobalProvider = ({ children }: { children: React.ReactNode }) => {
  return (
    <QueryClientProvider client={queryClient}>
      <PrimeReactProvider value={{ pt: Tailwind }}>
        {children}
      </PrimeReactProvider>
    </QueryClientProvider>
  );
};

export default GlobalProvider;
