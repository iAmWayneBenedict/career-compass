import { PrimeReactProvider } from "primereact/api";
import type { APIOptions } from "primereact/api";
import Tailwind from "primereact/passthrough/tailwind";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";

const queryClient = new QueryClient();

const PrimeReactProviderValue = {
  pt: Tailwind,
  appendTo: "self",
  ripple: true,
  nullSortOrder: -1,
  inputStyle: "filled",
  zIndex: {
    modal: 1100, // dialog, sidebar
    overlay: 1000, // dropdown, overlaypanel
    menu: 1000, // overlay menus
    tooltip: 1100, // tooltip
    toast: 1200, // toast
  },
  autoZIndex: true,
} satisfies APIOptions;

const GlobalProvider = ({ children }: { children: React.ReactNode }) => {
  return (
    <QueryClientProvider client={queryClient}>
      <PrimeReactProvider value={PrimeReactProviderValue}>
        {children}
      </PrimeReactProvider>
    </QueryClientProvider>
  );
};

export default GlobalProvider;
